<?php

namespace App\Http\Controllers;

use App\Models\Resenha;
use App\Models\ResenhaLike;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ResenhaLikeController extends Controller
{
    public function store(Resenha $resenha): RedirectResponse
    {
        $user = Auth::user();
        
        if (!$user->likedResenhas()->where('resenha_id', $resenha->id)->exists()) {
            $user->likedResenhas()->attach($resenha->id);
        }

        return redirect()->back()->with('success', 'Resenha curtida!');
    }

    public function destroy(Resenha $resenha): RedirectResponse
    {
        $user = Auth::user();
        
        if ($user->likedResenhas()->where('resenha_id', $resenha->id)->exists()) {
            $user->likedResenhas()->detach($resenha->id);
        }

        return redirect()->back()->with('success', 'Curtida removida!');
    }
}