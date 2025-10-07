<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * Seguir um usuário
     */
    public function store(Request $request, User $user)
    {
        $currentUser = Auth::user();
        
        // Verificar se não está tentando seguir a si mesmo
        if ($currentUser->id === $user->id) {
            return $this->respond($request, 'Você não pode seguir a si mesmo.', 422, 'error');
        }
        
        // Verificar se já não está seguindo
        if (!$currentUser->follows()->where('followed_id', $user->id)->exists()) {
            // syncWithoutDetaching protege de condição de corrida / duplicação
            $currentUser->follows()->syncWithoutDetaching([$user->id]);
            return $this->respond($request, "Você agora está seguindo {$user->name}.", 200, 'success');
        }

        return $this->respond($request, "Você já está seguindo {$user->name}.", 200, 'info');
    }

    /**
     * Deixar de seguir um usuário
     */
    public function destroy(Request $request, User $user)
    {
        $currentUser = Auth::user();
        
        // Verificar se está seguindo
        if ($currentUser->follows()->where('followed_id', $user->id)->exists()) {
            $currentUser->follows()->detach($user->id);
            return $this->respond($request, "Você deixou de seguir {$user->name}.", 200, 'success');
        }

        return $this->respond($request, "Você não estava seguindo {$user->name}.", 200, 'info');
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

    /**
     * Helper para responder HTML (redirect+flash) ou JSON conforme Accept header.
     */
    protected function respond(Request $request, string $message, int $status, string $level)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'status' => $level,
                'message' => $message,
            ], $status);
        }

        // fallback redirect
        return redirect()->back()->with($level, $message);
    }
}