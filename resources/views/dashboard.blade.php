@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="row mb-5">
    <div class="col-12">
        <!-- Hero agora usa o tema parchment em vez de bg-primary azul -->
        <div class="parchment-panel soft-shadow rounded-3 p-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 brand-font mb-3" style="color: var(--old-ink);">
                        <i class="fas fa-book-open me-3" style="color: var(--old-accent);"></i>Bem-vindo à Literare
                    </h1>
                    <p class="lead mb-4" style="color: var(--old-ink-muted);">
                        Sua comunidade literária online. Descubra novos livros, compartilhe resenhas 
                        e conecte-se com outros leitores apaixonados.
                    </p>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-user-plus me-2"></i>Cadastre-se
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Entrar
                        </a>
                    @else
                        <a href="{{ route('resenhas.create') }}" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-plus me-2"></i>Nova Resenha
                        </a>
                        <a href="{{ route('posts.create') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-edit me-2"></i>Novo Post
                        </a>
                    @endguest
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-books display-1" style="opacity: 0.15; color: var(--old-accent);"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-5">
    <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 60px; height: 60px;">
                    <i class="fas fa-users text-primary fs-4"></i>
                </div>
                <h3 class="card-title h1 text-primary">{{ $totalUsuarios }}</h3>
                <p class="card-text text-muted">Leitores Cadastrados</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 60px; height: 60px;">
                    <i class="fas fa-book text-success fs-4"></i>
                </div>
                <h3 class="card-title h1 text-success">{{ $totalLivros }}</h3>
                <p class="card-text text-muted">Livros Cadastrados</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 60px; height: 60px;">
                    <i class="fas fa-star text-warning fs-4"></i>
                </div>
                <h3 class="card-title h1 text-warning">{{ $resenhasRecentes->count() }}</h3>
                <p class="card-text text-muted">Resenhas Recentes</p>
            </div>
        </div>
    </div>
</div>

<!-- Content Sections -->
<div class="row">
    <!-- Recent Reviews -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-star text-warning me-2"></i>Resenhas Recentes
                    </h4>
                    <a href="{{ route('resenhas.index') }}" class="btn btn-outline-primary btn-sm">
                        Ver todas <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @forelse($resenhasRecentes as $resenha)
                    <div class="border-bottom pb-3 mb-3 @if($loop->last) border-bottom-0 mb-0 pb-0 @endif">
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-3">
                                @if($resenha->user->foto_perfil)
                                    <img src="{{ asset('storage/' . $resenha->user->foto_perfil) }}" 
                                         class="rounded-circle" width="40" height="40">
                                @else
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" 
                                         style="width: 40px; height: 40px;">
                                        {{ substr($resenha->user->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <a href="{{ route('profile.show', $resenha->user->id) }}" 
                                           class="fw-bold text-decoration-none">
                                            {{ $resenha->user->name }}
                                        </a>
                                        <div class="text-muted small">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $resenha->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    @if($resenha->avaliacao)
                                        <div class="badge bg-warning text-dark">
                                            <i class="fas fa-star me-1"></i>{{ $resenha->avaliacao }}/5
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-2">
                            <a href="{{ route('resenhas.show', $resenha->id) }}" class="text-decoration-none">
                                {{ $resenha->livro->titulo }}
                            </a>
                        </h6>
                        <p class="text-muted mb-2">{{ Str::limit($resenha->conteudo, 150) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('resenhas.show', $resenha->id) }}" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i>Ler mais
                            </a>
                            <div class="text-muted small">
                                <i class="fas fa-heart text-danger me-1"></i>{{ $resenha->likesCount() }}
                                <i class="fas fa-comment ms-3 me-1"></i>{{ $resenha->comments->count() }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-book-open text-muted display-4 mb-3"></i>
                        <p class="text-muted">Nenhuma resenha ainda. Seja o primeiro a compartilhar!</p>
                        @auth
                            <a href="{{ route('resenhas.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Escrever Resenha
                            </a>
                        @endauth
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Popular Books & Quick Links -->
    <div class="col-lg-4 mb-4">
        <!-- Popular Books -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h5 class="card-title mb-0">
                    <i class="fas fa-fire text-danger me-2"></i>Livros Populares
                </h5>
            </div>
            <div class="card-body">
                @forelse($livrosPopulares as $livro)
                    <div class="d-flex align-items-center mb-3 @if($loop->last) mb-0 @endif">
                        <div class="me-3">
                            @if($livro->imagem_capa)
                                <img src="{{ asset('storage/' . $livro->imagem_capa) }}" 
                                     class="rounded" width="50" height="70" style="object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 70px;">
                                    <i class="fas fa-book text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">
                                <a href="{{ route('livros.show', $livro->id) }}" class="text-decoration-none">
                                    {{ Str::limit($livro->titulo, 30) }}
                                </a>
                            </h6>
                            <div class="text-muted small">
                                <i class="fas fa-star me-1"></i>{{ $livro->resenhas_count }} resenhas
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">Nenhum livro cadastrado ainda.</p>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        @auth
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt text-warning me-2"></i>Ações Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('resenhas.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nova Resenha
                        </a>
                        <a href="{{ route('posts.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>Novo Post
                        </a>
                        @if(auth()->check() && auth()->user()->is_admin)
                            <!-- Admin-only quick links grouped together -->
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-users me-2"></i>Usuários
                            </a>
                            <a href="{{ route('livros.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-book me-2"></i>Livros
                            </a>
                            <a href="{{ route('autores.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-user-edit me-2"></i>Autores
                            </a>
                            <a href="{{ route('editoras.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-building me-2"></i>Editoras
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endauth
    </div>
</div>
@endsection