@extends('layouts.app')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1 class="brand-font mb-1" style="color: var(--old-ink);">Editoras</h1>
        <div class="text-muted" style="font-family: 'Crimson Text', serif;">Catálogo de editoras cadastradas</div>
    </div>
    @if(auth()->check() && auth()->user()->is_admin)
        <a href="{{ route('editoras.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Nova Editora</a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success parchment-panel py-2 mb-4">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger parchment-panel py-2 mb-4">{{ session('error') }}</div>
@endif

@if($editoras->count() === 0)
    <div class="parchment-panel text-center soft-shadow">
        <i class="fas fa-building display-5 mb-3" style="color: var(--old-accent);"></i>
        <p class="mb-0 text-muted">Nenhuma editora cadastrada.</p>
    </div>
@else
    <div class="row g-4">
        @foreach($editoras as $editora)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 position-relative">
                    <div class="card-body d-flex flex-column">
                        <h5 class="mb-1" style="font-family: 'Cinzel', serif; font-size:1.05rem;">
                            <a href="{{ route('editoras.show', $editora) }}" class="stretched-link text-decoration-none" style="color: var(--old-ink);">
                                {{ Str::limit($editora->nome, 40) }}
                            </a>
                        </h5>
                        <div class="small text-muted mb-2"><i class="fas fa-book me-1"></i>{{ $editora->livros_count }} livro(s)</div>
                        @if(auth()->check() && auth()->user()->is_admin)
                            <div class="mt-auto d-flex flex-wrap gap-2">
                                <a href="{{ route('editoras.edit', $editora) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit me-1"></i>Editar</a>
                                <form action="{{ route('editoras.destroy', $editora) }}" method="POST" onsubmit="return confirm('Excluir esta editora?');">
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
    <div class="mt-4">{{ $editoras->links() }}</div>
@endif
@endsection
