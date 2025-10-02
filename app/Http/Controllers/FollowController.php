<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * Seguir um usuário
     */
    public function store(User $user): RedirectResponse
    {
        $currentUser = Auth::user();
        
        // Verificar se não está tentando seguir a si mesmo
        if ($currentUser->id === $user->id) {
            return redirect()->back()->with('error', 'Você não pode seguir a si mesmo.');
        }
        
        // Verificar se já não está seguindo
        if (!$currentUser->follows()->where('followed_id', $user->id)->exists()) {
            $currentUser->follows()->attach($user->id);
            return redirect()->back()->with('success', "Você agora está seguindo {$user->name}.");
        }
        
        return redirect()->back()->with('info', "Você já está seguindo {$user->name}.");
    }

    /**
     * Deixar de seguir um usuário
     */
    public function destroy(User $user): RedirectResponse
    {
        $currentUser = Auth::user();
        
        // Verificar se está seguindo
        if ($currentUser->follows()->where('followed_id', $user->id)->exists()) {
            $currentUser->follows()->detach($user->id);
            return redirect()->back()->with('success', "Você deixou de seguir {$user->name}.");
        }
        
        return redirect()->back()->with('info', "Você não estava seguindo {$user->name}.");
    }

    /**
     * Listar seguidores de um usuário
     */
    public function followers(User $user)
    {
        $followers = $user->followers()->paginate(20);
        return view('users.followers', compact('user', 'followers'));
    }

    /**
     * Listar usuários que um usuário está seguindo
     */
    public function following(User $user)
    {
        $following = $user->follows()->paginate(20);
        return view('users.following', compact('user', 'following'));
    }
}