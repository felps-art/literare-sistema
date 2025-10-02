@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Cabeçalho -->
    <div class="bg-white rounded-lg shadow mb-6 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }} está seguindo</h1>
                <p class="text-gray-600">{{ $following->total() }} usuário{{ $following->total() === 1 ? '' : 's' }}</p>
            </div>
            <a href="{{ route('profile.show', $user->id) }}" 
               class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">
                <i class="fas fa-arrow-left mr-1"></i>Voltar ao Perfil
            </a>
        </div>
    </div>

    <!-- Lista de usuários seguindo -->
    <div class="bg-white rounded-lg shadow">
        @if($following->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($following as $followedUser)
                    <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                        <div class="flex items-center space-x-3">
                            <!-- Foto do perfil -->
                            @if($followedUser->foto_perfil)
                                <img class="h-12 w-12 rounded-full object-cover" 
                                     src="{{ asset('storage/' . $followedUser->foto_perfil) }}" 
                                     alt="{{ $followedUser->name }}">
                            @else
                                <div class="h-12 w-12 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold">
                                    {{ substr($followedUser->name, 0, 1) }}
                                </div>
                            @endif
                            
                            <!-- Informações do usuário -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">
                                    <a href="{{ route('profile.show', $followedUser->id) }}" 
                                       class="hover:text-blue-600">{{ $followedUser->name }}</a>
                                </h3>
                                <p class="text-sm text-gray-500">
                                    {{ $followedUser->followersCount() }} seguidores • 
                                    {{ $followedUser->followingCount() }} seguindo
                                </p>
                            </div>
                        </div>

                        <!-- Botão de ação -->
                        @auth
                            @if(auth()->id() !== $followedUser->id)
                                @if(auth()->user()->isFollowing($followedUser))
                                    <form action="{{ route('users.unfollow', $followedUser->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                                            Deixar de Seguir
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('users.follow', $followedUser->id) }}" method="POST">
                                        @csrf
                                        <button class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                            Seguir
                                        </button>
                                    </form>
                                @endif
                            @endif
                        @endauth
                    </div>
                @endforeach
            </div>

            <!-- Paginação -->
            <div class="p-4 border-t">
                {{ $following->links() }}
            </div>
        @else
            <div class="p-8 text-center">
                <i class="fas fa-user-friends text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Não está seguindo ninguém</h3>
                <p class="text-gray-500">{{ $user->name }} ainda não está seguindo nenhum usuário.</p>
            </div>
        @endif
    </div>
</div>
@endsection