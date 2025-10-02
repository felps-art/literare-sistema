@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-4">
            <h1 class="h3 mb-1">
                <i class="fas fa-users text-primary me-2"></i>Todos os Usuários
            </h1>
            <p class="text-muted mb-0">Encontre leitores com interesses similares</p>
        </div>

        <div class="card-body p-0">
            @foreach($users as $user)
            <div class="p-4 border-bottom @if($loop->last) border-bottom-0 @endif">
                <div class="row align-items-center">
                    <!-- Foto do perfil -->
                    <div class="col-auto">
                        @if($user->foto_perfil)
                            <img class="rounded-circle" width="60" height="60" style="object-fit: cover;" 
                                 src="{{ asset('storage/' . $user->foto_perfil) }}" 
                                 alt="{{ $user->name }}">
                        @else
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" 
                                 style="width: 60px; height: 60px; font-size: 1.5rem; font-weight: bold;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <!-- Informações do usuário -->
                    <div class="col">
                        <h5 class="mb-1">
                            <a href="{{ route('profile.show', $user->id) }}" 
                               class="text-decoration-none fw-bold">
                                {{ $user->name }}
                            </a>
                        </h5>
                        <p class="text-muted mb-2 small">{{ $user->email }}</p>
                        <div class="d-flex gap-4 small text-muted">
                            <span><i class="fas fa-users me-1"></i>{{ $user->followersCount() }} seguidores</span>
                            <span><i class="fas fa-star me-1"></i>{{ $user->resenhas_count }} resenhas</span>
                            <span><i class="fas fa-bookmark me-1"></i>{{ $user->livros_status_count }} livros</span>
                        </div>
                    </div>

                    <!-- Botões de ação -->
                    <div class="col-auto">
                        <div class="d-flex gap-2">
                            @auth
                                @if(auth()->id() !== $user->id)
                                    @if(auth()->user()->isFollowing($user))
                                        <form action="{{ route('users.unfollow', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-user-minus me-1"></i>Seguindo
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('users.follow', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-success">
                                                <i class="fas fa-user-plus me-1"></i>Seguir
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            @endauth
                            <a href="{{ route('profile.show', $user->id) }}" 
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-eye me-1"></i>Ver Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Paginação -->
        @if($users->hasPages())
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection