<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Post;
use App\Models\Resenha;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $limit = 25;
        $cursor = $request->query('cursor');

        $followIds = $user ? $user->follows()->pluck('users.id')->toArray() : [];
        if ($user) { $followIds[] = $user->id; }

        $activitiesQuery = Activity::with(['user','subject'])
            ->when($followIds, fn($q) => $q->whereIn('user_id', $followIds))
            ->orderByDesc('id');

        if ($cursor) {
            $activitiesQuery->where('id', '<', (int)$cursor);
        }

        $activities = $activitiesQuery->limit($limit + 1)->get();
        $nextCursor = null;
        if ($activities->count() > $limit) {
            $nextCursor = $activities->slice($limit)->first()->id;
            $activities = $activities->take($limit);
        }

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

        $suggestedUsers = collect();
        if ($user) {
            $suggestedUsers = User::query()
                ->where('id', '!=', $user->id)
                ->whereNotIn('id', $followIds)
                ->withCount(['followers'])
                ->orderByDesc('followers_count')
                ->limit(6)
                ->get();
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
