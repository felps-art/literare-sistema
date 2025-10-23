<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentLikeController extends Controller
{
    public function store(Request $request, Comment $comment): RedirectResponse|JsonResponse
    {
        $user = Auth::user();

        if (!$user->likedComments()->where('comment_id', $comment->id)->exists()) {
            $user->likedComments()->attach($comment->id);
        }

        if ($request->wantsJson()) {
            $comment->refresh();
            return response()->json([
                'liked' => true,
                'likes_count' => $comment->likesCount(),
                'comment_id' => $comment->id,
            ]);
        }

        return back();
    }

    public function destroy(Request $request, Comment $comment): RedirectResponse|JsonResponse
    {
        $user = Auth::user();

        if ($user->likedComments()->where('comment_id', $comment->id)->exists()) {
            $user->likedComments()->detach($comment->id);
        }

        if ($request->wantsJson()) {
            $comment->refresh();
            return response()->json([
                'liked' => false,
                'likes_count' => $comment->likesCount(),
                'comment_id' => $comment->id,
            ]);
        }

        return back();
    }
}
