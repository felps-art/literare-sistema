@extends('layouts.app')

@section('content')
    <div class="parchment-panel soft-shadow mb-3 d-flex justify-content-between align-items-center">
        <h1 class="h5 brand-font m-0" style="color:var(--old-ink);">
            <i class="fas fa-star me-2" style="color:var(--old-accent);"></i>Todas as Resenhas
        </h1>
        @auth
        <a href="{{ route('resenhas.create') }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-pen me-1"></i>Escrever Resenha
        </a>
        @endauth
    </div>

    <div class="parchment-panel soft-shadow mb-3">
        <div class="row g-2 align-items-center">
            <div class="col-sm-4">
                <select class="form-select form-select-sm">
                    <option>Ordenar por: Mais recentes</option>
                    <option>Mais antigas</option>
                    <option>Melhores avaliações</option>
                </select>
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-sm" placeholder="Buscar resenhas..." />
            </div>
            <div class="col-sm-2 text-end">
                <button class="btn btn-sm btn-outline-secondary w-100"><i class="fas fa-search me-1"></i>Buscar</button>
            </div>
        </div>
    </div>

    @foreach($resenhas as $resenha)
        <div class="parchment-panel soft-shadow mb-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <a href="{{ route('resenhas.show', $resenha->id) }}" class="text-decoration-none fw-semibold" style="color:var(--old-ink);">
                        {{ $resenha->livro->titulo }}
                    </a>
                    <div class="small text-muted mt-1 d-flex align-items-center gap-2">
                        <a href="{{ route('profile.show', $resenha->user->id) }}" class="text-muted text-decoration-none d-flex align-items-center gap-2">
                            @if($resenha->user->foto_perfil)
                                <img class="rounded-circle" width="18" height="18" style="object-fit:cover;" src="{{ asset('storage/' . $resenha->user->foto_perfil) }}" alt="{{ $resenha->user->name }}">
                            @else
                                <span class="badge bg-secondary rounded-circle" style="width:18px;height:18px; display:inline-flex;align-items:center;justify-content:center;">{{ substr($resenha->user->name, 0, 1) }}</span>
                            @endif
                            <span>{{ $resenha->user->name }}</span>
                        </a>
                        <span>·</span>
                        <span>{{ $resenha->created_at->format('d/m/Y') }}</span>
                        @if($resenha->spoiler)
                            <span class="badge bg-danger">Spoiler</span>
                        @endif
                    </div>
                </div>
                @if($resenha->avaliacao)
                    <span class="badge bg-warning text-dark"><i class="fas fa-star me-1"></i>{{ $resenha->avaliacao }}/5</span>
                @endif
            </div>
            <div class="text-muted" style="font-family:'Crimson Text', serif;">{{ Str::limit(strip_tags($resenha->conteudo), 300) }}</div>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <a href="{{ route('resenhas.show', $resenha->id) }}" class="small text-decoration-none"><i class="fas fa-eye me-1"></i>Ler resenha completa</a>
                <div class="d-flex align-items-center gap-3 small text-muted">
                    <span><i class="fas fa-comment me-1"></i>{{ $resenha->comments->count() }}</span>
                    @auth
                        <button
                            class="btn btn-sm {{ $resenha->isLikedBy(auth()->user()) ? 'btn-outline-danger' : 'btn-outline-secondary' }}"
                            data-like
                            data-type="resenha"
                            data-id="{{ $resenha->id }}"
                            data-state="{{ $resenha->isLikedBy(auth()->user()) ? 'liked' : 'unliked' }}"
                        >
                            <i class="{{ $resenha->isLikedBy(auth()->user()) ? 'fas fa-heart text-danger' : 'far fa-heart' }}"></i>
                            <span class="ms-1" data-like-count>{{ $resenha->likesCount() }}</span>
                        </button>
                    @endauth
                    @guest
                        <span><i class="far fa-heart"></i><span class="ms-1">{{ $resenha->likesCount() }}</span></span>
                    @endguest
                </div>
            </div>
        </div>
    @endforeach

    <div class="mt-3">{{ $resenhas->links() }}</div>
@endsection