<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use App\Http\Requests\AutorRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AutorController extends Controller
{
    public function __construct()
    {
        $this->middleware(\App\Http\Middleware\AdminMiddleware::class)->only([
            'create', 'store', 'edit', 'update', 'destroy'
        ]);
    }
    /**
     * Lista autores com contagem de livros associados.
     */
    public function index(): View
    {
        $autores = Autor::withCount('livros')
            ->orderBy('nome')
            ->paginate(20);
        return view('autores.index', compact('autores'));
    }

    /**
     * Formulário de criação.
     */
    public function create(): View
    {
        return view('autores.create');
    }

    /**
     * Persistir novo autor.
     */
    public function store(AutorRequest $request): RedirectResponse
    {
        $autor = Autor::create($request->validated());
        return redirect()->route('autores.show', $autor->id)
            ->with('success', 'Autor criado com sucesso!');
    }

    /**
     * Exibir autor.
     */
    public function show(int $id): View
    {
        $autor = Autor::with('livros')->findOrFail($id);
        return view('autores.show', compact('autor'));
    }

    /**
     * Formulário de edição.
     */
    public function edit(int $id): View
    {
        $autor = Autor::findOrFail($id);
        return view('autores.edit', compact('autor'));
    }

    /**
     * Atualizar autor.
     */
    public function update(AutorRequest $request, int $id): RedirectResponse
    {
        $autor = Autor::findOrFail($id);
        $autor->update($request->validated());
        return redirect()->route('autores.show', $autor->id)
            ->with('success', 'Autor atualizado com sucesso!');
    }

    /**
     * Excluir autor.
     */
    public function destroy(int $id): RedirectResponse
    {
        $autor = Autor::findOrFail($id);
        $autor->delete();
        return redirect()->route('autores.index')
            ->with('success', 'Autor excluído com sucesso!');
    }
}
