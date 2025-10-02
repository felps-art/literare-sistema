<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Resenha;
use App\Models\ResenhaComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ResenhaCommentController extends Controller
{
    public function store(CommentRequest $request, Resenha $resenha): RedirectResponse
    {
        ResenhaComment::create([
            'resenha_id' => $resenha->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('resenhas.show', $resenha)->with('success','Comentário adicionado.');
    }

    public function destroy(ResenhaComment $comment): RedirectResponse
    {
        if ($comment->user_id !== Auth::id() && $comment->resenha->user_id !== Auth::id()) {
            abort(403,'Ação não autorizada.');
        }
        $resenhaId = $comment->resenha_id;
        $comment->delete();
        return redirect()->route('resenhas.show', $resenhaId)->with('success','Comentário removido.');
    }
}
