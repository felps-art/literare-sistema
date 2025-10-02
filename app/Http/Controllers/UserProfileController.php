<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resenha;
use App\Models\UsuarioLivroStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::withCount(['resenhas', 'livrosStatus'])
            ->orderBy('name')
            ->paginate(20);

        return view('users.index', compact('users'));
    }

    /**
     * Display the specified user profile.
     */
    public function show($id)
    {
        $user = User::withCount(['resenhas', 'livrosQueroLer', 'livrosLendo', 'livrosLidos'])
            ->findOrFail($id);

        $resenhas = Resenha::with('livro')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $estatisticas = [
            'quero_ler' => $user->livrosQueroLer()->count(),
            'lendo' => $user->livrosLendo()->count(),
            'lidos' => $user->livrosLidos()->count(),
            'resenhas' => $user->resenhas()->count(),
        ];

        return view('users.show', compact('user', 'resenhas', 'estatisticas'));
    }

    /**
     * Display user's posts (resenhas).
     */
    public function posts($id)
    {
        $user = User::findOrFail($id);
        
        $resenhas = Resenha::with('livro')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('users.posts', compact('user', 'resenhas'));
    }

    /**
     * Show the form for editing the user profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    /**
     * Update the user profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto_perfil')) {
            $fotoPath = $request->file('foto_perfil')->store('profiles', 'public');
            $user->foto_perfil = $fotoPath;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('profile.show', $user->id)
            ->with('success', 'Perfil atualizado com sucesso!');
    }
}