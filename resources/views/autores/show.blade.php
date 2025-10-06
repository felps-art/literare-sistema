@extends('layouts.app')

@section('content')
<div class="parchment-panel soft-shadow mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
        <div>
            <h1 class="brand-font mb-2" style="color: var(--old-ink);">{{ $autor->nome }}</h1>
            <div class="text-muted small"><i class="fas fa-tag me-1"></i>Código: {{ $autor->codigo }}</div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('autores.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Voltar</a>
            @if(auth()->check() && auth()->user()->is_admin)
                <a href="{{ route('autores.edit', $autor->id) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit me-1"></i>Editar</a>
                <form action="{{ route('autores.destroy', $autor->id) }}" method="POST" onsubmit="return confirm('Excluir este autor?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm" type="submit"><i class="fas fa-trash me-1"></i>Excluir</button>
                </form>
            @endif
        </div>
    </div>
    <div>
        <h2 class="h5 brand-font" style="color: var(--old-ink);">Biografia</h2>
        <p class="mb-0" style="font-family: 'Crimson Text', serif;">{{ $autor->biografia ?? 'Sem biografia cadastrada.' }}</p>
    </div>
</div>

<div class="parchment-panel soft-shadow">
    <h2 class="h5 brand-font mb-3" style="color: var(--old-ink);"><i class="fas fa-book me-2" style="color: var(--old-accent);"></i>Livros</h2>
    @if($autor->livros->count())
        <div class="row g-4">
            @foreach($autor->livros as $livro)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0">
                        <div class="position-relative">
                            <a href="{{ route('livros.show', $livro->id) }}" class="text-decoration-none">
                                @if($livro->imagem_capa)
                                    <img src="{{ asset('storage/' . $livro->imagem_capa) }}" class="card-img-top" style="height: 200px; object-fit: cover; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center" style="height:200px; background:#efe2c9; color: var(--old-ink-muted); font-size:2.2rem;">
                                        <i class="fas fa-book"></i>
                                    </div>
                                @endif
                            </a>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="mb-1" style="font-family: 'Cinzel', serif; font-size:.9rem;">
                                <a href="{{ route('livros.show', $livro->id) }}" class="text-decoration-none" style="color: var(--old-ink);">
                                    {{ Str::limit($livro->titulo, 50) }}
                                </a>
                            </h6>
                            <div class="small text-muted mb-2">{{ $livro->codigo_livro }}</div>
                            <div class="mt-auto">
                                <a href="{{ route('livros.show', $livro->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye me-1"></i>Detalhes</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted small mb-0">Nenhum livro associado.</p>
    @endif
</div>
@endsection
