@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Resenha -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <!-- Cabeçalho -->
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $resenha->livro->titulo }}</h1>
                    <div class="flex items-center mt-2 space-x-4">
                        <a href="{{ route('profile.show', $resenha->user->id) }}" 
                           class="flex items-center space-x-2 text-gray-600 hover:text-blue-600">
                            @if($resenha->user->foto_perfil)
                                <img class="h-8 w-8 rounded-full" 
                                     src="{{ asset('storage/' . $resenha->user->foto_perfil) }}" 
                                     alt="{{ $resenha->user->name }}">
                            @else
                                <div class="h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                                    {{ substr($resenha->user->name, 0, 1) }}
                                </div>
                            @endif
                            <span class="font-medium">{{ $resenha->user->name }}</span>
                        </a>
                        <span class="text-gray-400">•</span>
                        <span class="text-gray-500">{{ $resenha->created_at->format('d/m/Y \\à\\s H:i') }}</span>
                    </div>
                </div>

                @if($resenha->avaliacao)
                    <div class="bg-yellow-50 px-4 py-2 rounded-full">
                        <div class="flex items-center">
                            <span class="text-yellow-600 font-bold text-xl mr-1">{{ $resenha->avaliacao }}</span>
                            <span class="text-yellow-400 text-2xl">★</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Alert de spoiler -->
            @if($resenha->spoiler)
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <span class="text-red-600 text-lg mr-2">⚠️</span>
                        <div>
                            <h3 class="font-semibold text-red-800">Atenção: Contém Spoilers</h3>
                            <p class="text-red-700 text-sm">Esta resenha revela detalhes importantes da história.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Conteúdo da resenha -->
            <div class="prose max-w-none text-gray-700 mb-6">
                {!! nl2br(e($resenha->conteudo)) !!}
            </div>

            <!-- Informações do livro -->
            <div class="bg-gray-50 rounded-lg p-4 mt-6">
                <h3 class="font-semibold text-gray-900 mb-2">Sobre o livro</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600"><strong>Autor(es):</strong> 
                            {{ $resenha->livro->autores->pluck('nome')->join(', ') }}
                        </p>
                        <p class="text-sm text-gray-600"><strong>Editora:</strong> 
                            {{ $resenha->livro->editora->nome }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600"><strong>Ano:</strong> 
                            {{ $resenha->livro->ano_publicacao }}
                        </p>
                        <p class="text-sm text-gray-600"><strong>Páginas:</strong> 
                            {{ $resenha->livro->numero_paginas }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sistema de curtidas -->
            <div class="flex items-center justify-between mt-6 pt-4 border-t">
                @auth
                    <div class="flex items-center gap-4">
                        @php($liked = $resenha->isLikedBy(auth()->user()))
                        @if($liked)
                            <form action="{{ route('resenhas.unlike',$resenha) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="flex items-center gap-2 text-red-500 hover:text-red-600 transition-colors" title="Remover curtida">
                                    <i class="fas fa-heart text-lg"></i>
                                    <span class="font-medium">{{ $resenha->likesCount() }}</span>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('resenhas.like',$resenha) }}" method="POST">
                                @csrf
                                <button class="flex items-center gap-2 text-gray-500 hover:text-red-500 transition-colors" title="Curtir">
                                    <i class="far fa-heart text-lg"></i>
                                    <span class="font-medium">{{ $resenha->likesCount() }}</span>
                                </button>
                            </form>
                        @endif
                    </div>
                @else
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="far fa-heart"></i>
                        <span>{{ $resenha->likesCount() }} curtida{{ $resenha->likesCount() === 1 ? '' : 's' }}</span>
                        <span>•</span>
                        <a href="{{ route('login') }}" class="text-blue-600 underline">Entre para curtir</a>
                    </div>
                @endauth

                <!-- Ações do autor -->
                @auth
                    @if(auth()->id() == $resenha->user_id)
                        <div class="flex space-x-4">
                            <a href="{{ route('resenhas.edit', $resenha->id) }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                Editar Resenha
                            </a>
                            
                            <form action="{{ route('resenhas.destroy', $resenha->id) }}" method="POST" 
                                  onsubmit="return confirm('Tem certeza que deseja excluir esta resenha?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                                    Excluir
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- Comentários -->
    <div class="bg-white rounded-lg shadow" id="comentarios">
        <div class="p-6">
            <h2 class="text-xl font-bold mb-4">Comentários ({{ $resenha->comments->count() }})</h2>

            <div class="space-y-4 mb-6">
                @forelse($resenha->comments as $comment)
                    <div class="bg-gray-50 p-4 rounded">
                        <div class="flex justify-between items-start mb-1">
                            <div class="text-sm text-gray-600">
                                <a href="{{ route('profile.show',$comment->user_id) }}" class="font-medium text-gray-700 hover:text-blue-600">{{ $comment->user->name }}</a>
                                <span class="text-gray-400 mx-1">•</span>
                                <span>{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->id() === $resenha->user_id))
                                <form action="{{ route('resenha-comments.destroy',$comment) }}" method="POST" onsubmit="return confirm('Remover este comentário?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs text-red-600 hover:underline">Remover</button>
                                </form>
                            @endif
                        </div>
                        <p class="text-gray-700">{{ $comment->content }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">Nenhum comentário ainda.</p>
                @endforelse
            </div>

            @auth
            <form action="{{ route('resenhas.comments.store',$resenha) }}" method="POST" class="bg-white border rounded p-4">
                @csrf
                <textarea name="content" rows="3" class="w-full border rounded p-2" placeholder="Escreva um comentário..." required>{{ old('content') }}</textarea>
                @error('content')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                <button class="mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Comentar</button>
            </form>
            @else
                <p class="text-sm text-gray-600">Faça <a href="{{ route('login') }}" class="text-blue-600 underline">login</a> para comentar.</p>
            @endauth
        </div>
    </div>
</div>
@endsection