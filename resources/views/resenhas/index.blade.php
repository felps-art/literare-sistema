@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Cabeçalho -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Todas as Resenhas</h1>
        
        @auth
            <a href="{{ route('resenhas.create') }}" 
               class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                ✏️ Escrever Resenha
            </a>
        @endauth
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <div class="flex space-x-4">
            <select class="border border-gray-300 rounded-lg px-3 py-2">
                <option>Ordenar por: Mais recentes</option>
                <option>Mais antigas</option>
                <option>Melhores avaliações</option>
            </select>
            
            <input type="text" placeholder="Buscar resenhas..." 
                   class="border border-gray-300 rounded-lg px-3 py-2 flex-1">
            
            <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">
                🔍 Buscar
            </button>
        </div>
    </div>

    <!-- Lista de resenhas -->
    <div class="space-y-6">
        @foreach($resenhas as $resenha)
            <div class="bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                <div class="p-6">
                    <!-- Cabeçalho da resenha -->
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <a href="{{ route('resenhas.show', $resenha->id) }}" 
                               class="text-xl font-bold text-gray-900 hover:text-blue-600">
                                {{ $resenha->livro->titulo }}
                            </a>
                            
                            <div class="flex items-center mt-2 space-x-4 text-sm text-gray-500">
                                <a href="{{ route('profile.show', $resenha->user->id) }}" 
                                   class="flex items-center space-x-2 hover:text-blue-600">
                                    @if($resenha->user->foto_perfil)
                                        <img class="h-6 w-6 rounded-full" 
                                             src="{{ asset('storage/' . $resenha->user->foto_perfil) }}" 
                                             alt="{{ $resenha->user->name }}">
                                    @else
                                        <div class="h-6 w-6 bg-gray-300 rounded-full flex items-center justify-center text-xs">
                                            {{ substr($resenha->user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <span>{{ $resenha->user->name }}</span>
                                </a>
                                <span>•</span>
                                <span>{{ $resenha->created_at->format('d/m/Y') }}</span>
                                
                                @if($resenha->spoiler)
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">
                                        ⚠️ Spoiler
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        @if($resenha->avaliacao)
                            <div class="flex items-center bg-yellow-50 px-3 py-1 rounded-full">
                                <span class="text-yellow-600 font-bold mr-1">{{ $resenha->avaliacao }}</span>
                                <span class="text-yellow-400">★</span>
                            </div>
                        @endif
                    </div>

                    <!-- Preview do conteúdo -->
                    <div class="prose max-w-none text-gray-700 mb-4">
                        {{ Str::limit(strip_tags($resenha->conteudo), 300) }}
                    </div>

                    <!-- Rodapé -->
                    <div class="flex justify-between items-center">
                        <a href="{{ route('resenhas.show', $resenha->id) }}" 
                           class="text-blue-600 hover:underline font-medium">
                            Ler resenha completa →
                        </a>
                        
                        <div class="flex space-x-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-comment"></i>
                                {{ $resenha->comments->count() }} comentário{{ $resenha->comments->count() === 1 ? '' : 's' }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-heart text-red-400"></i>
                                {{ $resenha->likesCount() }} curtida{{ $resenha->likesCount() === 1 ? '' : 's' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Paginação -->
    <div class="mt-6">
        {{ $resenhas->links() }}
    </div>
</div>
@endsection