<?php
// app/Http/Controllers/LivroController.php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Editora;
use App\Models\Autor;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    public function index()
    {
        $livros = Livro::with(['editora', 'autores', 'resenhas'])
            ->orderBy('titulo')
            ->paginate(20);

        return view('livros.index', compact('livros'));
    }

    public function create()
    {
        $editoras = Editora::orderBy('nome')->get();
        $autores = Autor::orderBy('nome')->get();
        return view('livros.create', compact('editoras', 'autores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'sinopse' => 'nullable|string',
            'codigo_livro' => 'required|unique:livros,codigo_livro',
            'ano_publicacao' => 'nullable|integer|min:1000|max:' . date('Y'),
            'numero_paginas' => 'nullable|integer|min:1',
            'editora_id' => 'required|exists:editoras,id',
            'autores' => 'required|array',
            'autores.*' => 'exists:autores,id',
            'imagem_capa' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $livro = Livro::create($request->except('autores'));

        if ($request->hasFile('imagem_capa')) {
            $livro->imagem_capa = $request->file('imagem_capa')->store('capas', 'public');
            $livro->save();
        }

        $livro->autores()->sync($request->autores);

        return redirect()->route('livros.show', $livro->id)
            ->with('success', 'Livro cadastrado com sucesso!');
    }

    public function show($id)
    {
        $livro = Livro::with(['editora', 'autores', 'resenhas.user'])
            ->findOrFail($id);

        return view('livros.show', compact('livro'));
    }

    public function edit($id)
    {
        $livro = Livro::with('autores')->findOrFail($id);
        $editoras = Editora::orderBy('nome')->get();
        $autores = Autor::orderBy('nome')->get();

        return view('livros.edit', compact('livro', 'editoras', 'autores'));
    }

    public function update(Request $request, $id)
    {
        $livro = Livro::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'sinopse' => 'nullable|string',
            'codigo_livro' => 'required|unique:livros,codigo_livro,' . $livro->id,
            'ano_publicacao' => 'nullable|integer|min:1000|max:' . date('Y'),
            'numero_paginas' => 'nullable|integer|min:1',
            'editora_id' => 'required|exists:editoras,id',
            'autores' => 'required|array',
            'autores.*' => 'exists:autores,id',
            'imagem_capa' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $livro->update($request->except('autores'));

        if ($request->hasFile('imagem_capa')) {
            $livro->imagem_capa = $request->file('imagem_capa')->store('capas', 'public');
            $livro->save();
        }

        $livro->autores()->sync($request->autores);

        return redirect()->route('livros.show', $livro->id)
            ->with('success', 'Livro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $livro = Livro::findOrFail($id);
        $livro->delete();

        return redirect()->route('livros.index')
            ->with('success', 'Livro excluído com sucesso!');
    }
}