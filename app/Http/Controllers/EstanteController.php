<?php

namespace App\Http\Controllers; 

use App\Models\Livro; 
use App\Models\StatusLeitura; 
use App\Models\UsuarioLivroStatus; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 

class EstanteController extends Controller
{
    /**
     * Lista todos os livros presentes na estante do usuário autenticado.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $itens = \App\Models\UsuarioLivroStatus::query()
            ->with(['livro:id,titulo,imagem_capa', 'statusLeitura:id,nome'])
            ->where('user_id', $user->id)
            ->orderByDesc('updated_at')
            ->paginate(12);

        if ($request->wantsJson()) {
            return response()->json([
                'data' => $itens,
            ]);
        }

        return view('estante.index', [
            'itens' => $itens,
        ]);
    }
    /**
     * Armazena ou atualiza o status de leitura e avaliação de um livro para o usuário autenticado.
     */
    public function store(Request $request, Livro $livro)
    {
        $request->validate([
            'status_leitura_id' => 'required|exists:status_leitura,id',
            'avaliacao' => 'nullable|integer|min:1|max:5',
        ]);

        $user = Auth::user();

        $registro = UsuarioLivroStatus::updateOrCreate(
            [
                'user_id' => $user->id,
                'livro_id' => $livro->id,
            ],
            [
                'status_leitura_id' => $request->status_leitura_id,
                'avaliacao' => $request->avaliacao,
            ]
        );

        return back()->with('success', 'Estante atualizada.');
    }

    /**
     * Remove o registro de estante do usuário para o livro.
     */
    public function destroy(Livro $livro)
    {
        $user = Auth::user();
        UsuarioLivroStatus::where('user_id', $user->id)
            ->where('livro_id', $livro->id)
            ->delete();

        return back()->with('success', 'Removido da estante.');
    }
}
