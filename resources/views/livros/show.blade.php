@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex flex-col md:flex-row md:space-x-6">
        <div class="md:w-1/4 mb-4 md:mb-0">
            @if($livro->imagem_capa)
                <img src="{{ asset('storage/' . $livro->imagem_capa) }}" class="w-full rounded shadow" />
            @else
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-500">Sem capa</div>
            @endif
        </div>
        <div class="md:w-3/4">
            <h1 class="text-3xl font-bold mb-2">{{ $livro->titulo }}</h1>
            <p class="text-sm text-gray-600 mb-4">Código: {{ $livro->codigo_livro }}</p>
            <p><span class="font-semibold">Editora:</span> {{ $livro->editora->nome ?? '-' }}</p>
            <p><span class="font-semibold">Autores:</span> {{ $livro->autores->pluck('nome')->join(', ') }}</p>
            <div class="grid grid-cols-2 gap-4 mt-4 text-sm">
                <div><span class="font-semibold">Ano:</span> {{ $livro->ano_publicacao ?? '-' }}</div>
                <div><span class="font-semibold">Páginas:</span> {{ $livro->numero_paginas ?? '-' }}</div>
            </div>
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-2">Sinopse</h2>
                <p class="text-gray-700 leading-relaxed">{{ $livro->sinopse ?? 'Sem sinopse informada.' }}</p>
            </div>
            <div class="mt-6 flex space-x-3">
                @if(auth()->check() && auth()->user()->is_admin)
                    <a href="{{ route('livros.edit', $livro->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</a>
                    <form action="{{ route('livros.destroy', $livro->id) }}" method="POST" onsubmit="return confirm('Excluir este livro?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Excluir</button>
                    </form>
                @endif
                <a href="{{ route('livros.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Voltar</a>
            </div>
        </div>
    </div>
</div>
@endsection
