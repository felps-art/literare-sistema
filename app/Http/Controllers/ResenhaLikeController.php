<?php

namespace App\Http\Controllers;

use App\Models\Resenha;
use App\Models\ResenhaLike;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ResenhaLikeController extends Controller
{
    public function store(Request $request, Resenha $resenha): RedirectResponse|JsonResponse
    {
        $user = Auth::user();
        
        if (!$user->likedResenhas()->where('resenha_id', $resenha->id)->exists()) {
            $user->likedResenhas()->attach($resenha->id);
        }
        if ($request->wantsJson()) {
            $count = $resenha->likes()->count();
            return response()->json([
                'liked' => true,
                'likes_count' => $count,
                'resenha_id' => $resenha->id,
            ]);
        }
        return redirect()->back()->with('success', 'Resenha curtida!');
    }

    public function destroy(Request $request, Resenha $resenha): RedirectResponse|JsonResponse
    {
        $user = Auth::user();
        
        if ($user->likedResenhas()->where('resenha_id', $resenha->id)->exists()) {
            $user->likedResenhas()->detach($resenha->id);
        }
        if ($request->wantsJson()) {
            $count = $resenha->likes()->count();
            return response()->json([
                'liked' => false,
                'likes_count' => $count,
                'resenha_id' => $resenha->id,
            ]);
        }
        return redirect()->back()->with('success', 'Curtida removida!');
    }
}