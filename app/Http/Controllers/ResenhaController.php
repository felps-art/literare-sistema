<?php

namespace App\Http\Controllers;

use App\Models\Resenha;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResenhaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resenhas = Resenha::with(['user', 'livro'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('resenhas.index', compact('resenhas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $livros = Livro::orderBy('titulo')->get();
        return view('resenhas.create', compact('livros'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'livro_id' => 'required|exists:livros,id',
            'conteudo' => 'required|string|min:10',
            'avaliacao' => 'nullable|integer|between:1,5',
            'spoiler' => 'boolean',
        ]);

        Resenha::create([
            'user_id' => Auth::id(),
            'livro_id' => $request->livro_id,
            'conteudo' => $request->conteudo,
            'avaliacao' => $request->avaliacao,
            'spoiler' => $request->spoiler ?? false,
        ]);

        return redirect()->route('resenhas.index')
            ->with('success', 'Resenha publicada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $resenha = Resenha::with(['user', 'livro.autores', 'livro.editora', 'comments.user'])
            ->findOrFail($id);

        return view('resenhas.show', compact('resenha'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $resenha = Resenha::where('user_id', Auth::id())->findOrFail($id);
        $livros = Livro::orderBy('titulo')->get();

        return view('resenhas.edit', compact('resenha', 'livros'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $resenha = Resenha::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'conteudo' => 'required|string|min:10',
            'avaliacao' => 'nullable|integer|between:1,5',
            'spoiler' => 'boolean',
        ]);

        $resenha->update($request->all());

        return redirect()->route('resenhas.show', $resenha->id)
            ->with('success', 'Resenha atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $resenha = Resenha::where('user_id', Auth::id())->findOrFail($id);
        $resenha->delete();

        return redirect()->route('resenhas.index')
            ->with('success', 'Resenha excluída com sucesso!');
    }
}