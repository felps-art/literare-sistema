<?php

namespace App\Http\Controllers;

use App\Models\ResenhaComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResenhaCommentLikeController extends Controller
{
    public function store(Request $request, ResenhaComment $comment): RedirectResponse|JsonResponse
    {
        $user = Auth::user();

        if (!$user->likedResenhaComments()->where('resenha_comment_id', $comment->id)->exists()) {
            $user->likedResenhaComments()->attach($comment->id);
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

    public function destroy(Request $request, ResenhaComment $comment): RedirectResponse|JsonResponse
    {
        $user = Auth::user();

        if ($user->likedResenhaComments()->where('resenha_comment_id', $comment->id)->exists()) {
            $user->likedResenhaComments()->detach($comment->id);
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
