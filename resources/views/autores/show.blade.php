@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-start mb-4">
        <div>
            <h1 class="text-3xl font-bold mb-2">{{ $autor->nome }}</h1>
            <p class="text-sm text-gray-500">Código: {{ $autor->codigo }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('autores.edit', $autor->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</a>
            <form action="{{ route('autores.destroy', $autor->id) }}" method="POST" onsubmit="return confirm('Excluir este autor?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Excluir</button>
            </form>
            <a href="{{ route('autores.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Voltar</a>
        </div>
    </div>

    <div class="mt-6">
        <h2 class="text-xl font-semibold mb-2">Biografia</h2>
        <p class="text-gray-700 leading-relaxed">{{ $autor->biografia ?? 'Sem biografia cadastrada.' }}</p>
    </div>

    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-2">Livros</h2>
        @if($autor->livros->count())
            <ul class="list-disc ml-5 space-y-1">
                @foreach($autor->livros as $livro)
                    <li>
                        <a href="{{ route('livros.show', $livro->id) }}" class="text-blue-600 hover:underline">{{ $livro->titulo }}</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 text-sm">Nenhum livro associado.</p>
        @endif
    </div>
</div>
@endsection
