@extends('layouts.app')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1 class="brand-font mb-1" style="color: var(--old-ink);">Autores</h1>
        <div class="text-muted" style="font-family: 'Crimson Text', serif;">Catálogo de autores cadastrados</div>
    </div>
    @if(auth()->check() && auth()->user()->is_admin)
        <a href="{{ route('autores.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Novo Autor</a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success parchment-panel py-2 mb-4">{{ session('success') }}</div>
@endif

@if($autores->count() === 0)
    <div class="parchment-panel text-center soft-shadow">
        <i class="fas fa-feather display-5 mb-3" style="color: var(--old-accent);"></i>
        <p class="mb-0 text-muted">Nenhum autor cadastrado.</p>
    </div>
@else
    <div class="row g-4">
        @foreach($autores as $autor)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 position-relative">
                    <div class="card-body d-flex flex-column">
                        <h5 class="mb-1" style="font-family: 'Cinzel', serif; font-size:1.05rem;">
                            <a href="{{ route('autores.show', $autor->id) }}" class="stretched-link text-decoration-none" style="color: var(--old-ink);">
                                {{ Str::limit($autor->nome, 40) }}
                            </a>
                        </h5>
                        <div class="small text-muted mb-2"><i class="fas fa-tag me-1"></i>{{ $autor->codigo }}</div>
                        <div class="mb-3 small text-muted"><i class="fas fa-book me-1"></i>{{ $autor->livros_count }} livro(s)</div>
                        @if(auth()->check() && auth()->user()->is_admin)
                            <div class="mt-auto d-flex flex-wrap gap-2">
                                <a href="{{ route('autores.edit', $autor->id) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit me-1"></i>Editar</a>
                                <form action="{{ route('autores.destroy', $autor->id) }}" method="POST" onsubmit="return confirm('Excluir este autor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit"><i class="fas fa-trash me-1"></i>Excluir</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $autores->links() }}
    </div>
@endif
@endsection
