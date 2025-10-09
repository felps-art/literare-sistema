@extends('layouts.app')

@section('content')
<div class="parchment-panel soft-shadow mb-3 d-flex justify-content-between align-items-center">
    <h1 class="h5 brand-font m-0" style="color:var(--old-ink);">
        <i class="fas fa-books me-2" style="color:var(--old-accent);"></i>Minha Estante
    </h1>
    <span class="text-muted small">Seus livros e status de leitura</span>
</div>

@if($itens->count() === 0)
    <div class="parchment-panel soft-shadow text-center text-muted">Você ainda não adicionou livros à sua estante.</div>
@else
    <div class="row g-3">
        @foreach($itens as $item)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100">
                    @if($item->livro?->imagem_capa)
                        <img src="{{ asset('storage/' . $item->livro->imagem_capa) }}" class="card-img-top" style="height:220px; object-fit:cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height:220px;">
                            <i class="fas fa-book fa-2x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title" style="color:var(--old-ink);">{{ $item->livro?->titulo ?? 'Livro' }}</h5>
                        <p class="card-text small text-muted mb-2">
                            Status: <span class="fw-semibold">{{ $item->statusLeitura?->nome ?? '-' }}</span>
                            @if(!is_null($item->avaliacao))
                                <br>Nota: <span class="fw-semibold">{{ $item->avaliacao }}/5</span>
                            @endif
                        </p>
                        <div class="mt-auto d-flex gap-2">
                            <a href="{{ route('livros.show', $item->livro_id) }}" class="btn btn-outline-primary btn-sm w-100">
                                <i class="fas fa-eye me-1"></i>Ver livro
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-3">{{ $itens->links() }}</div>
@endif
@endsection
