@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Cabeçalho do perfil -->
    <div class="parchment-panel soft-shadow mb-3">
        <div class="row align-items-center g-3">
                <!-- Foto do perfil -->
                <div class="col-auto">
                    @if($user->foto_perfil)
                        <img class="rounded-circle" width="100" height="100" style="object-fit: cover;" 
                             src="{{ asset('storage/' . $user->foto_perfil) }}" 
                             alt="{{ $user->name }}">
                    @else
                    <span class="badge bg-secondary rounded-circle" style="width:100px;height:100px; display:inline-flex;align-items:center;justify-content:center; font-size:2.2rem;">{{ substr($user->name, 0, 1) }}</span>
                    @endif
                </div>

                <!-- Informações principais -->
            <div class="col">
                <h1 class="h4 brand-font mb-1" style="color:var(--old-ink);">
                        {{ $user->name }}
                        @if($user->is_admin)
                        <span class="badge bg-danger ms-2">Administrador</span>
                        @endif
                    </h1>
                <p class="text-muted mb-2">{{ $user->email }}</p>
                    
                    <!-- Estatísticas -->
                <div class="row g-3 small text-muted">
                        <div class="col-6 col-md-2 text-center">
                            <a href="{{ route('users.followers', $user->id) }}" class="text-decoration-none">
                            <div class="h5 fw-bold mb-0" style="color:var(--old-ink);">{{ $user->followersCount() }}</div>
                                <small class="text-muted">Seguidores</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-2 text-center">
                            <a href="{{ route('users.following', $user->id) }}" class="text-decoration-none">
                            <div class="h5 fw-bold mb-0" style="color:var(--old-ink);">{{ $user->followingCount() }}</div>
                                <small class="text-muted">Seguindo</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-2 text-center">
                        <div class="h5 fw-bold text-primary mb-0">{{ $estatisticas['quero_ler'] }}</div>
                            <small class="text-muted">Quero Ler</small>
                        </div>
                        <div class="col-6 col-md-2 text-center">
                        <div class="h5 fw-bold text-warning mb-0">{{ $estatisticas['lendo'] }}</div>
                            <small class="text-muted">Lendo</small>
                        </div>
                        <div class="col-6 col-md-2 text-center">
                        <div class="h5 fw-bold text-success mb-0">{{ $estatisticas['lidos'] }}</div>
                            <small class="text-muted">Lidos</small>
                        </div>
                        <div class="col-6 col-md-2 text-center">
                        <div class="h5 fw-bold text-info mb-0">{{ $estatisticas['resenhas'] }}</div>
                            <small class="text-muted">Resenhas</small>
                        </div>
                    </div>
                </div>

                <!-- Botões de ação -->
            <div class="col-auto d-flex gap-2">
                    @auth
                        @if(auth()->id() == $user->id)
                            <!-- Botão de editar perfil próprio -->
                        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-edit me-1"></i>Editar Perfil
                            </a>
                        @else
                            <!-- Botões de seguir/deixar de seguir -->
                            @if(auth()->user()->isFollowing($user))
                                <form action="{{ route('users.unfollow', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-user-minus me-1"></i>Deixar de Seguir
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('users.follow', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                <button class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-user-plus me-1"></i>Seguir
                                    </button>
                                </form>
                            @endif
                        @endif
                    @else
                        <!-- Usuário não logado -->
                    <a href="{{ route('login') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-sign-in-alt me-1"></i>Entrar para Seguir
                        </a>
                    @endauth
                </div>
        </div>
    </div>

    <!-- Abas de navegação -->
    <div class="parchment-panel soft-shadow mb-3 p-0">
        <div class="border-bottom px-3 pt-3">
            <ul class="nav nav-tabs border-0">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('profile.show', $user->id) }}">
                        <i class="fas fa-star me-1"></i>Resenhas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.posts', $user->id) }}">
                        <i class="fas fa-comments me-1"></i>Todas as Publicações
                    </a>
                </li>
            </ul>
        </div>

        <!-- Lista de resenhas -->
        <div class="p-3">
            @if($resenhas->count() > 0)
                @foreach($resenhas as $resenha)
                    <div class="border-bottom pb-3 mb-3 @if($loop->last) border-0 mb-0 pb-0 @endif">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5>
                                    <a href="{{ route('resenhas.show', $resenha->id) }}" 
                                       class="text-decoration-none fw-bold" style="color:var(--old-ink);">
                                        {{ $resenha->livro->titulo }}
                                    </a>
                                </h5>
                                @if($resenha->avaliacao)
                                    <div class="d-flex align-items-center mt-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $resenha->avaliacao)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-muted"></i>
                                            @endif
                                        @endfor
                                        <small class="ms-2 text-muted">{{ $resenha->avaliacao }}/5</small>
                                    </div>
                                @endif
                            </div>
                            <small class="text-muted">{{ $resenha->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        
                        <p class="text-muted mb-3">{{ Str::limit($resenha->conteudo, 300) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($resenha->spoiler)
                                    <span class="badge bg-danger me-2">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Contém Spoiler
                                    </span>
                                @endif
                                <a href="{{ route('resenhas.show', $resenha->id) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>Ler resenha completa
                                </a>
                            </div>
                            <div class="text-muted small">
                                <i class="fas fa-heart text-danger me-1"></i>{{ $resenha->likesCount() }}
                                <i class="fas fa-comment ms-3 me-1"></i>{{ $resenha->comments->count() }}
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Paginação -->
                <div class="d-flex justify-content-center mt-2">
                    {{ $resenhas->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-book-open text-muted display-4 mb-3"></i>
                    <h5 class="text-muted">Nenhuma resenha ainda</h5>
                    <p class="text-muted">Este usuário ainda não publicou nenhuma resenha.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection