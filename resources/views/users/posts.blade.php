@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Cabeçalho -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <div class="flex items-center space-x-4">
                @if($user->foto_perfil)
                    <img class="h-16 w-16 rounded-full object-cover" 
                         src="{{ asset('storage/' . $user->foto_perfil) }}" 
                         alt="{{ $user->name }}">
                @else
                    <div class="h-16 w-16 bg-gray-300 rounded-full flex items-center justify-center text-2xl font-bold">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <h1 class="text-2xl font-bold">Publicações de {{ $user->name }}</h1>
                    <p class="text-gray-600">{{ $resenhas->total() }} publicações no total</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de publicações -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            @if($resenhas->count() > 0)
                <div class="space-y-6">
                    @foreach($resenhas as $resenha)
                        <article class="border-b pb-6 last:border-b-0 last:pb-0">
                            <!-- Cabeçalho da publicação -->
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">
                                        <a href="{{ route('resenhas.show', $resenha->id) }}" 
                                           class="hover:text-blue-600">
                                            {{ $resenha->livro->titulo }}
                                        </a>
                                    </h2>
                                    <p class="text-sm text-gray-500 mt-1">
                                        por 
                                        <a href="{{ route('profile.show', $resenha->user->id) }}" 
                                           class="font-medium hover:text-blue-600">
                                            {{ $resenha->user->name }}
                                        </a>
                                        • {{ $resenha->created_at->format('d/m/Y \\à\\s H:i') }}
                                    </p>
                                </div>
                                
                                @if($resenha->avaliacao)
                                    <div class="flex items-center bg-yellow-50 px-3 py-1 rounded-full">
                                        <span class="text-yellow-600 font-bold mr-1">{{ $resenha->avaliacao }}</span>
                                        <span class="text-yellow-400">★</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Conteúdo -->
                            <div class="prose max-w-none text-gray-700 mb-3">
                                {!! Str::limit(strip_tags($resenha->conteudo), 500) !!}
                            </div>

                            <!-- Metadados -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    @if($resenha->spoiler)
                                        <span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">
                                            ⚠️ Contém Spoiler
                                        </span>
                                    @endif
                                    
                                    <a href="{{ route('resenhas.show', $resenha->id) }}#comentarios" 
                                       class="text-gray-500 hover:text-gray-700 text-sm">
                                        💬 Comentários
                                    </a>
                                </div>
                                
                                <a href="{{ route('resenhas.show', $resenha->id) }}" 
                                   class="text-blue-600 text-sm font-medium hover:underline">
                                    Ler completa →
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Paginação -->
                <div class="mt-6">
                    {{ $resenhas->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">📚</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhuma publicação encontrada</h3>
                    <p class="text-gray-600">Este usuário ainda não publicou nenhuma resenha.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection