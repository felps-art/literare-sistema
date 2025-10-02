@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Autores</h1>
        <a href="{{ route('autores.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Novo Autor</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b">
                <th class="py-2">Nome</th>
                <th class="py-2">Código</th>
                <th class="py-2">Livros</th>
                <th class="py-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($autores as $autor)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-2">{{ $autor->nome }}</td>
                    <td class="py-2">{{ $autor->codigo }}</td>
                    <td class="py-2">{{ $autor->livros_count }}</td>
                    <td class="py-2 space-x-2">
                        <a href="{{ route('autores.show', $autor->id) }}" class="text-blue-600 text-sm">Ver</a>
                        <a href="{{ route('autores.edit', $autor->id) }}" class="text-yellow-600 text-sm">Editar</a>
                        <form action="{{ route('autores.destroy', $autor->id) }}" method="POST" class="inline" onsubmit="return confirm('Excluir este autor?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 text-sm" type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $autores->links() }}
    </div>
</div>
@endsection
