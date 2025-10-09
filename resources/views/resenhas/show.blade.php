@extends('layouts.app')

@section('content')
    <div class="parchment-panel soft-shadow mb-3 d-flex justify-content-between align-items-start">
        <div>
            <h1 class="h5 brand-font m-0" style="color:var(--old-ink);">{{ $resenha->livro->titulo }}</h1>
            <div class="small text-muted d-flex align-items-center gap-2 mt-1">
                <a href="{{ route('profile.show', $resenha->user->id) }}" class="text-muted text-decoration-none d-flex align-items-center gap-2">
                    @if($resenha->user->foto_perfil)
                        <img class="rounded-circle" width="22" height="22" style="object-fit:cover;" src="{{ asset('storage/' . $resenha->user->foto_perfil) }}" alt="{{ $resenha->user->name }}">
                    @else
                        <span class="badge bg-secondary rounded-circle" style="width:22px;height:22px; display:inline-flex;align-items:center;justify-content:center;">{{ substr($resenha->user->name, 0, 1) }}</span>
                    @endif
                    <span>{{ $resenha->user->name }}</span>
                </a>
                <span>·</span>
                <span>{{ $resenha->created_at->format('d/m/Y \à\s H:i') }}</span>
            </div>
        </div>
        <div class="d-flex gap-2">
            @if(auth()->check() && auth()->id() == $resenha->user_id)
                <a href="{{ route('resenhas.edit', $resenha->id) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit me-1"></i>Editar</a>
                <form action="{{ route('resenhas.destroy', $resenha->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta resenha?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash me-1"></i>Excluir</button>
                </form>
            @endif
            <a href="{{ route('resenhas.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Voltar</a>
        </div>
    </div>

    @if($resenha->spoiler)
        <div class="alert alert-danger parchment-panel soft-shadow">
            <i class="fas fa-exclamation-triangle me-2"></i>Atenção: Contém Spoilers
        </div>
    @endif

    <div class="parchment-panel soft-shadow mb-3">
        @if($resenha->avaliacao)
            <div class="mb-2">
                <span class="badge bg-warning text-dark"><i class="fas fa-star me-1"></i>{{ $resenha->avaliacao }}/5</span>
            </div>
        @endif
        <div class="mb-3" style="font-family:'Crimson Text', serif; color:var(--old-ink);">{!! nl2br(e($resenha->conteudo)) !!}</div>
        <div class="row small g-2">
            <div class="col-sm-6"><strong class="text-muted">Autor(es):</strong> {{ $resenha->livro->autores->pluck('nome')->join(', ') }}</div>
            <div class="col-sm-3"><strong class="text-muted">Editora:</strong> {{ $resenha->livro->editora->nome }}</div>
            <div class="col-sm-3"><strong class="text-muted">Ano/Páginas:</strong> {{ $resenha->livro->ano_publicacao }} / {{ $resenha->livro->numero_paginas }}</div>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="small text-muted"><i class="fas fa-comment me-1"></i>{{ $resenha->comments->count() }}</div>
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
            @else
                <span class="small text-muted"><i class="far fa-heart"></i> <span class="ms-1">{{ $resenha->likesCount() }}</span></span>
            @endauth
        </div>
    </div>

    <div class="parchment-panel soft-shadow" id="comentarios">
        <h2 class="h6 brand-font mb-3" style="color:var(--old-ink);">Comentários ({{ $resenha->comments->count() }})</h2>
        <div class="mb-3">
            @forelse($resenha->comments as $comment)
                <div class="border-bottom pb-2 mb-2">
                    <div class="d-flex justify-content-between align-items-start small text-muted">
                        <div>
                            <a href="{{ route('profile.show',$comment->user_id) }}" class="text-muted text-decoration-none">{{ $comment->user->name }}</a>
                            <span>· {{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->id() === $resenha->user_id))
                            <form action="{{ route('resenha-comments.destroy',$comment) }}" method="POST" onsubmit="return confirm('Remover este comentário?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-link btn-sm text-danger p-0">Remover</button>
                            </form>
                        @endif
                    </div>
                    <div style="white-space:pre-line; color:var(--old-ink);">{{ $comment->content }}</div>
                </div>
            @empty
                <div class="text-muted small">Nenhum comentário ainda.</div>
            @endforelse
        </div>

        @auth
            <form action="{{ route('resenhas.comments.store',$resenha) }}" method="POST" class="mt-2">
                @csrf
                <div class="mb-2">
                    <textarea name="content" rows="3" class="form-control" placeholder="Escreva um comentário..." required>{{ old('content') }}</textarea>
                    @error('content')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <button class="btn btn-sm btn-primary"><i class="fas fa-paper-plane me-1"></i>Comentar</button>
            </form>
        @else
            <p class="small text-muted">Faça <a href="{{ route('login') }}">login</a> para comentar.</p>
        @endauth
    </div>
@endsection