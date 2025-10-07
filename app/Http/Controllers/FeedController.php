<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Post;
use App\Models\Resenha;
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
}
