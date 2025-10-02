<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Post $post): RedirectResponse
    {
        $comment = Comment::create([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ]);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Comentário publicado.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        if ($comment->user_id !== Auth::id() && $comment->post->user_id !== Auth::id()) {
            abort(403,'Ação não autorizada.');
        }
        $postId = $comment->post_id;
        $comment->delete();
        return redirect()->route('posts.show', $postId)->with('success','Comentário removido.');
    }
}
