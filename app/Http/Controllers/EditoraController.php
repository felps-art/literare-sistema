<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditoraRequest;
use App\Models\Editora;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EditoraController extends Controller
{
    public function index(): View
    {
        $editoras = Editora::withCount('livros')->orderBy('nome')->paginate(10);
        return view('editoras.index', compact('editoras'));
    }

    public function create(): View
    {
        return view('editoras.create');
    }

    public function store(EditoraRequest $request): RedirectResponse
    {
        $editora = Editora::create($request->validated());
        return redirect()->route('editoras.show', $editora)->with('success', 'Editora criada com sucesso.');
    }

    public function show(Editora $editora): View
    {
        $editora->load(['livros' => function ($q) { $q->select('id','titulo','editora_id'); }]);
        return view('editoras.show', compact('editora'));
    }

    public function edit(Editora $editora): View
    {
        return view('editoras.edit', compact('editora'));
    }

    public function update(EditoraRequest $request, Editora $editora): RedirectResponse
    {
        $editora->update($request->validated());
        return redirect()->route('editoras.show', $editora)->with('success', 'Editora atualizada com sucesso.');
    }

    public function destroy(Editora $editora): RedirectResponse
    {
        if ($editora->livros()->exists()) {
            return redirect()->route('editoras.show', $editora)
                ->with('error', 'Não é possível excluir: há livros associados.');
        }
        $editora->delete();
        return redirect()->route('editoras.index')->with('success', 'Editora excluída com sucesso.');
    }
}
