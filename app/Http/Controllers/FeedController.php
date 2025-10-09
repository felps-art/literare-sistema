<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Post;
use App\Models\Resenha;
use App\Models\Livro;
use App\Models\User;
use App\Services\FeedService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index(Request $request, FeedService $feedService)
    {
        $user = Auth::user();
        $cursor = $request->query('cursor');
        $limit = (int) $request->query('limit', 25);

        $feed = $feedService->fetch($user, $limit, $cursor ? (int)$cursor : null);
        $activities = $feed['items'];
        $nextCursor = $feed['nextCursor'];

        // Discover panels
        $since = now()->subDays(7);
        $trendingPosts = Post::with('user')
            ->withCount('likes')
            ->where('created_at', '>=', $since)
            ->orderByDesc('likes_count')
            ->limit(5)
            ->get();

        $trendingResenhas = Resenha::with(['user','livro'])
            ->withCount('likes')
            ->where('created_at', '>=', $since)
            ->orderByDesc('likes_count')
            ->limit(5)
            ->get();
        // followIds utilizados para suggestedUsers (feedService já tem a lógica dele internamente)
        $followIds = [];
        if ($user) {
            $followIds = $user->follows()->pluck('users.id')->toArray();
            $followIds[] = $user->id;
        }
        $suggestedUsers = $user ? User::query()
            ->where('id', '!=', $user->id)
            ->whereNotIn('id', $followIds)
            ->withCount(['followers'])
            ->orderByDesc('followers_count')
            ->limit(6)
            ->get() : collect();

        if ($request->wantsJson()) {
            return response()->json([
                'data' => $activities->map(fn($a) => [
                    'id' => $a->id,
                    'type' => $a->type,
                    'user' => [
                        'id' => $a->user?->id,
                        'name' => $a->user?->name,
                    ],
                    'subject_type' => $a->subject_type,
                    'subject_id' => $a->subject_id,
                    'meta' => $a->meta,
                    'created_at' => $a->created_at?->toIso8601String(),
                ]),
                'next_cursor' => $nextCursor,
            ]);
        }

        return view('feed.index', [
            'activities' => $activities,
            'nextCursor' => $nextCursor,
            'trendingPosts' => $trendingPosts,
            'trendingResenhas' => $trendingResenhas,
            'suggestedUsers' => $suggestedUsers,
        ]);
    }

    // Explorar: feed geral sem personalização (recentes)
    public function explore(Request $request)
    {
        // Filters and tab selection
        $tab = $request->query('tab', 'todos'); // todos | posts | resenhas | trending
        $tag = trim((string)$request->query('tag', ''));
        $livroId = $request->integer('livro_id');
        $period = $request->query('period', '24h'); // 24h | 7d | 30d | all
        $limit = max(5, min(50, (int)$request->query('limit', 20)));
        $cursor = $request->query('cursor');

        // Resolve period to a Carbon instance
        $now = now();
        $since = match ($period) {
            '7d' => $now->copy()->subDays(7),
            '30d' => $now->copy()->subDays(30),
            'all' => null,
            default => $now->copy()->subDay(),
        };

        // Base queries with filters
        $postsBase = Post::query()
            ->with(['user:id,name', 'photos'])
            ->withCount(['likes as likes_rel_count', 'comments'])
            ->when($since, fn($q) => $q->where('created_at', '>=', $since))
            ->when($tag !== '', function($q) use ($tag) {
                $q->where(function($w) use ($tag) {
                    $w->where('content', 'like', "%$tag%")
                      ->orWhere('content', 'like', "%#" . ltrim($tag, '#') . "%");
                });
            });

        $resenhasBase = Resenha::query()
            ->with(['user:id,name', 'livro:id,titulo'])
            ->withCount(['likes as likes_rel_count', 'comments'])
            ->when($since, fn($q) => $q->where('created_at', '>=', $since))
            ->when($tag !== '', function($q) use ($tag) {
                $q->where(function($w) use ($tag) {
                    $w->where('conteudo', 'like', "%$tag%")
                      ->orWhere('conteudo', 'like', "%#" . ltrim($tag, '#') . "%");
                });
            })
            ->when($livroId, fn($q) => $q->where('livro_id', $livroId));

        // Individual tabs pagination (page-based as before)
        $posts = $postsBase->clone()
            ->latest()
            ->paginate(10, ['*'], 'posts_page');

        $resenhas = $resenhasBase->clone()
            ->latest()
            ->paginate(10, ['*'], 'resenhas_page');

        // Combined cursor feed (Todos)
        $decodedCursor = null;
        if ($cursor) {
            $decoded = base64_decode($cursor, true);
            if ($decoded && str_contains($decoded, '|')) {
                [$cursorAt, $cursorId] = explode('|', $decoded, 2);
                try {
                    $decodedCursor = [Carbon::parse($cursorAt), (int)$cursorId];
                } catch (\Throwable $e) { $decodedCursor = null; }
            }
        }

        $applyCursor = function($q) use ($decodedCursor) {
            if (!$decodedCursor) return $q;
            [$cAt, $cId] = $decodedCursor;
            return $q->where(function($w) use ($cAt, $cId) {
                $w->where('created_at', '<', $cAt)
                  ->orWhere(function($w2) use ($cAt, $cId) {
                      $w2->where('created_at', '=', $cAt)
                         ->where('id', '<', $cId);
                  });
            });
        };

        $postsForCombined = $applyCursor((clone $postsBase))->latest()->limit($limit * 2)->get()->map(function($p){
            $p->kind = 'post';
            return $p;
        });
        $resenhasForCombined = $applyCursor((clone $resenhasBase))->latest()->limit($limit * 2)->get()->map(function($r){
            $r->kind = 'resenha';
            return $r;
        });

        $combinedAll = $postsForCombined->merge($resenhasForCombined)
            ->sortByDesc(function($item){ return [$item->created_at, $item->id]; })
            ->values();
        $combinedSlice = $combinedAll->take($limit + 1);
        $hasMore = $combinedSlice->count() > $limit;
        $combined = $combinedSlice->take($limit);
        $nextCursor = null;
        if ($hasMore) {
            $last = $combined->last();
            $nextCursor = base64_encode($last->created_at->toIso8601String() . '|' . $last->id);
        }

        // Trending (like rate = likes in window / hours in window)
        $hoursWindow = max(1, $since ? $since->diffInHours($now) : 24);
        $hoursExpr = "GREATEST(TIMESTAMPDIFF(HOUR, " . ($since ? "'$since'" : 'NOW() - INTERVAL 24 HOUR') . ", NOW()), 1)"; // fallback for SQL ordering

        $trendingPosts = Post::query()
            ->with('user')
            ->when($since, fn($q) => $q->where('created_at', '>=', $since))
            ->withCount(['likes as likes_window_count' => function($q) use ($since) {
                if ($since) { $q->where('created_at', '>=', $since); }
            }])
            ->orderByRaw("(COALESCE(likes_window_count, 0) / $hoursWindow) DESC")
            ->limit(10)
            ->get();
        foreach ($trendingPosts as $p) {
            $p->like_rate = ((int)($p->likes_window_count ?? 0)) / $hoursWindow;
        }

        $trendingResenhas = Resenha::query()
            ->with(['user','livro'])
            ->when($since, fn($q) => $q->where('created_at', '>=', $since))
            ->withCount(['likes as likes_window_count' => function($q) use ($since) {
                if ($since) { $q->where('created_at', '>=', $since); }
            }])
            ->orderByRaw("(COALESCE(likes_window_count, 0) / $hoursWindow) DESC")
            ->limit(10)
            ->get();
        foreach ($trendingResenhas as $r) {
            $r->like_rate = ((int)($r->likes_window_count ?? 0)) / $hoursWindow;
        }

        // Livro options (lightweight)
        $livrosOptions = Livro::orderBy('titulo')->limit(50)->get(['id','titulo']);

        if ($request->wantsJson()) {
            return response()->json([
                'tab' => $tab,
                'filters' => [ 'tag' => $tag, 'livro_id' => $livroId, 'period' => $period ],
                'posts' => $posts,
                'resenhas' => $resenhas,
                'combined' => $combined,
                'next_cursor' => $nextCursor,
                'trending_posts' => $trendingPosts,
                'trending_resenhas' => $trendingResenhas,
            ]);
        }

        return view('explore.index', [
            'tab' => $tab,
            'filters' => [ 'tag' => $tag, 'livro_id' => $livroId, 'period' => $period ],
            'posts' => $posts,
            'resenhas' => $resenhas,
            'combined' => $combined,
            'nextCursor' => $nextCursor,
            'trendingPosts' => $trendingPosts,
            'trendingResenhas' => $trendingResenhas,
            'livrosOptions' => $livrosOptions,
        ]);
    }
}
