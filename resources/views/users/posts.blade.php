@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Cabeçalho -->
    <div class="parchment-panel soft-shadow mb-3 d-flex align-items-center gap-3">
        @if($user->foto_perfil)
            <img class="rounded-circle" width="64" height="64" style="object-fit:cover;" src="{{ asset('storage/' . $user->foto_perfil) }}" alt="{{ $user->name }}">
        @else
            <span class="badge bg-secondary rounded-circle" style="width:64px;height:64px; display:inline-flex;align-items:center;justify-content:center; font-size:1.6rem;">{{ substr($user->name, 0, 1) }}</span>
        @endif
        <div>
            <h1 class="h5 brand-font m-0" style="color:var(--old-ink);">Publicações de {{ $user->name }}</h1>
            <div class="small text-muted">{{ $resenhas->total() }} publicações no total</div>
        </div>
    </div>

    <!-- Lista de publicações -->
    <div class="parchment-panel soft-shadow">
        @if($resenhas->count() > 0)
            @foreach($resenhas as $resenha)
                <article class="border-bottom pb-3 mb-3 @if($loop->last) border-0 mb-0 pb-0 @endif">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h2 class="h6 m-0">
                                <a href="{{ route('resenhas.show', $resenha->id) }}" class="text-decoration-none" style="color:var(--old-ink);">{{ $resenha->livro->titulo }}</a>
                            </h2>
                            <div class="small text-muted">por <a href="{{ route('profile.show', $resenha->user->id) }}" class="text-muted text-decoration-none">{{ $resenha->user->name }}</a> · {{ $resenha->created_at->format('d/m/Y \à\s H:i') }}</div>
                        </div>
                        @if($resenha->avaliacao)
                            <span class="badge bg-warning text-dark"><i class="fas fa-star me-1"></i>{{ $resenha->avaliacao }}</span>
                        @endif
                    </div>
                    <div class="text-muted" style="white-space:pre-line;">{!! Str::limit(strip_tags($resenha->conteudo), 500) !!}</div>
                    <div class="d-flex justify-content-between align-items-center mt-2 small">
                        <div class="d-flex align-items-center gap-2">
                            @if($resenha->spoiler)
                                <span class="badge bg-danger"><i class="fas fa-exclamation-triangle me-1"></i>Contém Spoiler</span>
                            @endif
                            <a href="{{ route('resenhas.show', $resenha->id) }}#comentarios" class="text-muted text-decoration-none"><i class="fas fa-comment me-1"></i>Comentários</a>
                        </div>
                        <a href="{{ route('resenhas.show', $resenha->id) }}" class="btn btn-sm btn-outline-primary">Ler completa →</a>
                    </div>
                </article>
            @endforeach

            <div class="d-flex justify-content-center">{{ $resenhas->links() }}</div>
        @else
            <div class="text-center py-5">
                <div class="display-6 mb-2">📚</div>
                <h5 class="text-muted">Nenhuma publicação encontrada</h5>
                <p class="text-muted">Este usuário ainda não publicou nenhuma resenha.</p>
            </div>
        @endif
    </div>
</div>
@endsection