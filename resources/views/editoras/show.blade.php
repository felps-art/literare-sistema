@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Editora: {{ $editora->nome }}</h1>
    <div class="flex gap-2">
        @if(auth()->check() && auth()->user()->is_admin)
            <a href="{{ route('editoras.edit',$editora) }}" class="px-3 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</a>
            <form action="{{ route('editoras.destroy',$editora) }}" method="POST" onsubmit="return confirm('Excluir esta editora?');">
                @csrf
                @method('DELETE')
                <button class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700">Excluir</button>
            </form>
        @endif
        <a href="{{ route('editoras.index') }}" class="px-3 py-2 border rounded">Voltar</a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
@endif

<div class="bg-white p-6 rounded shadow">
    <h2 class="font-semibold mb-2">Livros desta Editora ({{ $editora->livros->count() }})</h2>
    @if($editora->livros->isEmpty())
        <p class="text-gray-500">Nenhum livro associado.</p>
    @else
        <ul class="list-disc pl-5 space-y-1">
            @foreach($editora->livros as $livro)
                <li>
                    <a href="{{ route('livros.show',$livro) }}" class="text-blue-600 hover:underline">{{ $livro->titulo }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
