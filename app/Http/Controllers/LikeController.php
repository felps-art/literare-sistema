<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse|JsonResponse
    {
        $user = Auth::user();
        if (!$user->likedPosts()->where('post_id',$post->id)->exists()) {
            $user->likedPosts()->attach($post->id);
            $post->increment('likes_count');
        }
        if ($request->wantsJson()) {
            $post->refresh();
            return response()->json([
                'liked' => true,
                'likes_count' => $post->likes_count,
                'post_id' => $post->id,
            ]);
        }
        return back();
    }

    public function destroy(Request $request, Post $post): RedirectResponse|JsonResponse
    {
        $user = Auth::user();
        if ($user->likedPosts()->where('post_id',$post->id)->exists()) {
            $user->likedPosts()->detach($post->id);
            $post->decrement('likes_count');
        }
        if ($request->wantsJson()) {
            $post->refresh();
            return response()->json([
                'liked' => false,
                'likes_count' => $post->likes_count,
                'post_id' => $post->id,
            ]);
        }
        return back();
    }
}
