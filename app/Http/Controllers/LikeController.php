<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LikeController extends Controller
{
    public function store(Post $post): RedirectResponse
    {
        $user = Auth::user();
        if (!$user->likedPosts()->where('post_id',$post->id)->exists()) {
            $user->likedPosts()->attach($post->id);
            $post->increment('likes_count');
        }
        return back();
    }

    public function destroy(Post $post): RedirectResponse
    {
        $user = Auth::user();
        if ($user->likedPosts()->where('post_id',$post->id)->exists()) {
            $user->likedPosts()->detach($post->id);
            $post->decrement('likes_count');
        }
        return back();
    }
}
