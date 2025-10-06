@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Livros</h1>
        @if(auth()->check() && auth()->user()->is_admin)
            <a href="{{ route('livros.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Novo Livro</a>
        @endif
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b">
                <th class="py-2">Título</th>
                <th class="py-2">Código</th>
                <th class="py-2">Editora</th>
                <th class="py-2">Autores</th>
                <th class="py-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($livros as $livro)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-2">{{ $livro->titulo }}</td>
                    <td class="py-2">{{ $livro->codigo_livro }}</td>
                    <td class="py-2">{{ $livro->editora->nome ?? '-' }}</td>
                    <td class="py-2">{{ $livro->autores->pluck('nome')->join(', ') }}</td>
                    <td class="py-2 space-x-2">
                        <a href="{{ route('livros.show', $livro->id) }}" class="text-blue-600 text-sm">Ver</a>
                        @if(auth()->check() && auth()->user()->is_admin)
                            <a href="{{ route('livros.edit', $livro->id) }}" class="text-yellow-600 text-sm">Editar</a>
                            <form action="{{ route('livros.destroy', $livro->id) }}" method="POST" class="inline" onsubmit="return confirm('Excluir este livro?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 text-sm" type="submit">Excluir</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $livros->links() }}
    </div>
</div>
@endsection
