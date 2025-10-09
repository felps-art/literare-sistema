@extends('layouts.app')

@section('content')
@php
    $registroEstante = auth()->check() ? auth()->user()->livrosStatus()->where('livro_id', $livro->id)->first() : null;
    $statusAtual = $registroEstante?->status_leitura_id;
    $notaAtual = $registroEstante?->avaliacao;
    $statuses = \App\Models\StatusLeitura::query()
        ->whereIn('nome', ['Quero Ler','Lendo','Lido'])
        ->get();
    $mediaAvaliacao = $livro->usuariosStatus()->whereNotNull('avaliacao')->avg('avaliacao');
@endphp

<div class="parchment-panel soft-shadow mb-4">
    <div class="row g-4">
        <div class="col-md-3">
            @if($livro->imagem_capa)
                <img src="{{ asset('storage/' . $livro->imagem_capa) }}" class="img-fluid rounded shadow" />
            @else
                <div class="d-flex align-items-center justify-content-center rounded" style="height:260px; background:#efe2c9; color: var(--old-ink-muted);">
                    <i class="fas fa-book fa-3x"></i>
                </div>
            @endif
        </div>
        <div class="col-md-9">
            <h1 class="brand-font mb-2 d-flex align-items-center flex-wrap gap-2" style="color: var(--old-ink);">
                {{ $livro->titulo }}
                @if($mediaAvaliacao)
                    <span class="badge bg-warning text-dark" style="font-size:.75rem;">
                        <i class="fas fa-star me-1"></i>{{ number_format($mediaAvaliacao,1) }} média
                    </span>
                @endif
            </h1>
            <div class="text-muted mb-3" style="font-family: 'Crimson Text', serif;">Código: {{ $livro->codigo_livro }}</div>
            <p class="mb-1"><strong class="text-muted">Editora:</strong> {{ $livro->editora->nome ?? '-' }}</p>
            <p class="mb-1"><strong class="text-muted">Autores:</strong> {{ $livro->autores->pluck('nome')->join(', ') }}</p>
            <div class="row small mt-3">
                <div class="col-sm-4 mb-2"><strong class="text-muted">Ano:</strong> {{ $livro->ano_publicacao ?? '-' }}</div>
                <div class="col-sm-4 mb-2"><strong class="text-muted">Páginas:</strong> {{ $livro->numero_paginas ?? '-' }}</div>
            </div>
            <div class="mt-4">
                <h2 class="h5 brand-font" style="color: var(--old-ink);">Sinopse</h2>
                <p class="mb-0" style="font-family: 'Crimson Text', serif;">{{ $livro->sinopse ?? 'Sem sinopse informada.' }}</p>
            </div>
            <div class="mt-4 d-flex flex-wrap gap-2">
                @if(auth()->check() && auth()->user()->is_admin)
                    <a href="{{ route('livros.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Voltar
                    </a>
                    <a href="{{ route('livros.edit', $livro->id) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-edit me-1"></i>Editar
                    </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDeleteLivro">
                                                <i class="fas fa-trash me-1"></i>Excluir
                                        </button>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Voltar
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@if(auth()->check() && auth()->user()->is_admin)
<!-- Modal Confirmação Exclusão -->
<div class="modal fade" id="modalDeleteLivro" tabindex="-1" aria-labelledby="modalDeleteLivroLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:#f6eddc;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title brand-font" id="modalDeleteLivroLabel" style="color:var(--old-ink);"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <p class="mb-2">Tem certeza de que deseja excluir o livro <strong>{{ $livro->titulo }}</strong>?</p>
                <ul class="small text-muted ps-3 mb-0">
                        <li>Esta ação não pode ser desfeita.</li>
                        <li>Resenhas e relações de estante associadas podem ficar órfãs (verifique lógica de cascata).</li>
                </ul>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-between flex-wrap gap-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('livros.destroy', $livro->id) }}" method="POST" id="form-delete-livro" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash me-1"></i>Excluir Definitivamente</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@auth
<div class="parchment-panel soft-shadow mb-4" id="estante-section">
    <h3 class="h5 brand-font mb-3" style="color: var(--old-ink);"><i class="fas fa-books me-2" style="color: var(--old-accent);"></i>Sua Estante</h3>
    <div class="d-flex flex-wrap gap-2 mb-3">
        @if(!$registroEstante)
            <form action="{{ route('livros.estante.store', $livro->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status_leitura_id" value="1" />
                <button class="btn btn-sm btn-primary" type="submit">
                    <i class="fas fa-plus me-1"></i>Adicionar à Estante (Quero Ler)
                </button>
            </form>
        @else
            <form action="{{ route('livros.estante.destroy', $livro->id) }}" method="POST" onsubmit="return confirm('Remover este livro da sua estante?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" type="submit">
                    <i class="fas fa-times me-1"></i>Remover da Estante
                </button>
            </form>
        @endif

        @if($registroEstante)
            @foreach($statuses as $status)
                @php
                    $styleClassMap = [
                        'Quero Ler' => 'info',
                        'Lendo' => 'warning',
                        'Lido' => 'success',
                    ];
                    $kind = $styleClassMap[$status->nome] ?? 'primary';
                    $active = $statusAtual == $status->id;
                @endphp
                <form action="{{ route('livros.estante.store', $livro->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status_leitura_id" value="{{ $status->id }}" />
                    <button class="btn btn-sm {{ $active ? 'btn-'.$kind : 'btn-outline-'.$kind }}" type="submit">
                        {{ $status->nome }}
                    </button>
                </form>
            @endforeach
        @endif
    </div>

    <div class="d-flex align-items-center gap-2 mb-2">
        <strong class="small text-muted">Avaliação:</strong>
        <div class="d-inline-flex" id="rating-stars">
            @for($i=1;$i<=5;$i++)
                <form action="{{ route('livros.estante.store', $livro->id) }}" method="POST" class="m-0 p-0">
                    @csrf
                    <input type="hidden" name="status_leitura_id" value="{{ $statusAtual ?? 1 }}" />
                    <input type="hidden" name="avaliacao" value="{{ $i }}" />
                    <button type="submit" class="btn p-0 border-0 bg-transparent star-btn" style="font-size:1.3rem; line-height:1;">
                        <i class="fas fa-star {{ $notaAtual && $notaAtual >= $i ? 'text-warning' : 'text-muted' }}"></i>
                    </button>
                </form>
            @endfor
            @if($notaAtual)
                <form action="{{ route('livros.estante.store', $livro->id) }}" method="POST" class="ms-2">
                    @csrf
                    <input type="hidden" name="status_leitura_id" value="{{ $statusAtual ?? 1 }}" />
                    <input type="hidden" name="avaliacao" value="" />
                    <button class="btn btn-sm btn-outline-secondary" type="submit" title="Limpar avaliação">&times;</button>
                </form>
            @endif
        </div>
        @if($notaAtual)
            <span class="badge bg-warning text-dark ms-2">{{ $notaAtual }} / 5</span>
        @endif
    </div>
    <div class="small text-muted mt-2">
        @if($registroEstante)
            Status atual: <strong>{{ $registroEstante->statusLeitura->nome }}</strong>
            @if($notaAtual) • Nota: <strong>{{ $notaAtual }}</strong>@endif
            <br/>Última atualização: {{ $registroEstante->updated_at->diffForHumans() }}
        @else
            Ainda não está na sua estante.
        @endif
    </div>
</div>
@endauth

@if($livro->usuariosStatus()->exists())
    <div class="parchment-panel soft-shadow mb-4">
        <h3 class="h6 brand-font mb-3" style="color: var(--old-ink);"><i class="fas fa-user-friends me-2" style="color: var(--old-accent);"></i>Leitores</h3>
        <div class="row g-2">
            @foreach($livro->usuariosStatus()->with('user','statusLeitura')->latest()->take(12)->get() as $u)
                <div class="col-6 col-sm-4 col-lg-3">
                    <div class="d-flex align-items-center gap-2 small">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:34px;height:34px;background:#efe2c9; font-weight:600;">
                            {{ strtoupper(substr($u->user->name,0,1)) }}
                        </div>
                        <div>
                            <div class="fw-semibold" style="font-size:.75rem;">{{ Str::limit($u->user->name,14) }}</div>
                            <div class="text-muted" style="font-size:.65rem;">{{ $u->statusLeitura->nome }} @if($u->avaliacao) • {{ $u->avaliacao }}★ @endif</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection
@auth
@push('scripts')
<script>
// AJAX para status e avaliação
document.addEventListener('DOMContentLoaded', () => {
    const estanteSection = document.getElementById('estante-section');
    if(!estanteSection) return;

    function csrfToken(){
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }

    async function postEstante(data){
        const resp = await fetch("{{ route('livros.estante.store', $livro->id) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        if(!resp.ok){
            console.error('Erro ao atualizar estante');
            return;
        }
        // Recarrega parcialmente a seção (simplificação: recarregar página se quiser otimizar depois substituir por patch HTML)
        location.reload();
    }

    // Intercepta formulários de status
    estanteSection.querySelectorAll('form').forEach(form => {
        if(form.closest('#rating-stars')) return; // estrelas tratadas abaixo
        form.addEventListener('submit', (e) => {
            if(form.getAttribute('data-no-ajax') === 'true') return; // permitir fallback se necessário
            e.preventDefault();
            const fd = new FormData(form);
            const payload = Object.fromEntries(fd.entries());
            postEstante(payload);
        });
    });

    // Estrelas
    const ratingContainer = document.getElementById('rating-stars');
    if(ratingContainer){
        ratingContainer.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const fd = new FormData(form);
                const payload = Object.fromEntries(fd.entries());
                postEstante(payload);
            });
        });
    }
});
</script>
@endpush
@endauth
