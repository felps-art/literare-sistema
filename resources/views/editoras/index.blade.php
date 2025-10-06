@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Editoras</h1>
    @if(auth()->check() && auth()->user()->is_admin)
        <a href="{{ route('editoras.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Nova Editora</a>
    @endif
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
@endif

<table class="w-full border bg-white">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-2 text-left">Nome</th>
            <th class="p-2 text-left">Livros</th>
            <th class="p-2 text-left">Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($editoras as $editora)
            <tr class="border-t">
                <td class="p-2">{{ $editora->nome }}</td>
                <td class="p-2">{{ $editora->livros_count }}</td>
                <td class="p-2 flex gap-2">
                    <a href="{{ route('editoras.show',$editora) }}" class="text-blue-600 hover:underline">Ver</a>
                    @if(auth()->check() && auth()->user()->is_admin)
                        <a href="{{ route('editoras.edit',$editora) }}" class="text-yellow-600 hover:underline">Editar</a>
                        <form action="{{ route('editoras.destroy',$editora) }}" method="POST" onsubmit="return confirm('Excluir esta editora?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Excluir</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="3" class="p-4 text-center text-gray-500">Nenhuma editora cadastrada.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">{{ $editoras->links() }}</div>
@endsection
