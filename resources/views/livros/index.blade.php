@extends('layouts.app')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1 class="brand-font mb-1" style="color: var(--old-ink);">Livros</h1>
        <div class="text-muted" style="font-family: 'Crimson Text', serif;">Catálogo de obras cadastradas</div>
    </div>
    @if(auth()->check() && auth()->user()->is_admin)
        <a href="{{ route('livros.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Novo Livro
        </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success parchment-panel py-2 mb-4">{{ session('success') }}</div>
@endif

@if($livros->count() === 0)
    <div class="parchment-panel text-center soft-shadow">
        <i class="fas fa-book-open display-5 mb-3" style="color: var(--old-accent);"></i>
        <p class="mb-0 text-muted">Nenhum livro cadastrado ainda.</p>
    </div>
@else
    <div class="row g-4">
        @foreach($livros as $livro)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0">
                    <div class="position-relative">
                        <a href="{{ route('livros.show', $livro->id) }}" class="text-decoration-none">
                            @if($livro->imagem_capa)
                                <img src="{{ asset('storage/' . $livro->imagem_capa) }}" class="card-img-top" style="height: 210px; object-fit: cover; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                            @else
                                <div class="d-flex align-items-center justify-content-center" style="height:210px; background: #efe2c9; color: var(--old-ink-muted); font-size: 3rem;">
                                    <i class="fas fa-book"></i>
                                </div>
                            @endif
                        </a>
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-warning text-dark" title="Resenhas">
                                <i class="fas fa-star me-1"></i>{{ $livro->resenhas_count ?? $livro->resenhas()->count() }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column position-relative">
                        @auth
                            @php
                                $pivot = auth()->user()->livrosStatus->firstWhere('livro_id', $livro->id);
                                $badgeMap = [
                                    'Quero Ler' => ['class' => 'bg-info text-dark', 'short' => 'Quero Ler'],
                                    'Lendo' => ['class' => 'bg-warning text-dark', 'short' => 'Lendo'],
                                    'Lido' => ['class' => 'bg-success', 'short' => 'Lido'],
                                ];
                                $statusNome = $pivot?->statusLeitura?->nome;
                            @endphp
                            @if($statusNome && isset($badgeMap[$statusNome]))
                                <span class="badge position-absolute" style="top:-12px; left:12px; font-size:.65rem; {{ $statusNome==='Lido' ? 'color:#fff;' : '' }} {{ $statusNome==='Quero Ler' ? 'box-shadow:0 0 0 1px rgba(0,0,0,0.15);' : '' }} {{ $statusNome==='Lendo' ? 'box-shadow:0 0 0 1px rgba(0,0,0,0.15);' : '' }} {{ $statusNome==='Lido' ? 'box-shadow:0 0 0 1px rgba(0,0,0,0.25);' : '' }} {{ $statusNome==='Quero Ler' ? '' : '' }} {{ $statusNome==='Lendo' ? '' : '' }}" 
                                      title="Status: {{ $statusNome }}">
                                    {{ $badgeMap[$statusNome]['short'] }}
                                </span>
                            @endif
                        @endauth
                        <h5 class="card-title mb-1" style="font-family: 'Cinzel', serif; font-size: 1.05rem;">
                            <a href="{{ route('livros.show', $livro->id) }}" class="stretched-link text-decoration-none" style="color: var(--old-ink);">
                                {{ Str::limit($livro->titulo, 40) }}
                            </a>
                        </h5>
                        <div class="small mb-2 text-muted" style="font-family: 'Crimson Text', serif;">
                            <i class="fas fa-tag me-1"></i>{{ $livro->codigo_livro }}
                        </div>
                        <div class="mb-2" style="font-size: .95rem;">
                            <strong class="text-muted">Editora:</strong>
                            <span>{{ $livro->editora->nome ?? '—' }}</span>
                        </div>
                        <div class="mb-3 flex-grow-1" style="font-size: .9rem;">
                            <strong class="text-muted">Autor(es):</strong>
                            <span>{{ $livro->autores->pluck('nome')->join(', ') }}</span>
                        </div>
                        <div class="mt-auto d-flex flex-wrap gap-2">
                            <a href="{{ route('livros.show', $livro->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i>Detalhes
                            </a>
                            @if(auth()->check() && auth()->user()->is_admin)
                                <a href="{{ route('livros.edit', $livro->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit me-1"></i>Editar
                                </a>
                                <form action="{{ route('livros.destroy', $livro->id) }}" method="POST" onsubmit="return confirm('Excluir este livro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                        <i class="fas fa-trash me-1"></i>Excluir
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $livros->links() }}
    </div>
@endif
</div>
@endsection
