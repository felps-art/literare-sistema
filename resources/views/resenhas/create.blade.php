@extends('layouts.app')

@section('content')
<div class="container-lg">
    <div class="parchment-panel soft-shadow mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 brand-font m-0" style="color:var(--old-ink);">
                <i class="fas fa-feather-alt me-2" style="color:var(--old-accent);"></i>Escrever Nova Resenha
            </h1>
            <a href="{{ route('resenhas.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Voltar
            </a>
        </div>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <form action="{{ route('resenhas.store') }}" method="POST" id="resenha-create-form">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label for="livro_id" class="form-label fw-semibold">Livro *</label>
                        <select name="livro_id" id="livro_id" class="form-select" required>
                            <option value="">Selecione um livro...</option>
                            @foreach($livros as $livro)
                                <option value="{{ $livro->id }}" {{ old('livro_id') == $livro->id ? 'selected' : '' }}>
                                    {{ $livro->titulo }}@if($livro->autores->count() > 0) - {{ $livro->autores->first()->nome }}@endif ({{ $livro->ano_publicacao }})
                                </option>
                            @endforeach
                        </select>
                        @error('livro_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Avaliação (opcional)</label>
                        <div class="d-flex gap-1" id="avaliacao-stars" role="radiogroup" aria-label="Avaliação de 1 a 5">
                            @for($i=1;$i<=5;$i++)
                                <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-1 rating-star" data-rating="{{ $i }}" aria-label="{{ $i }} estrela" data-active="0">☆</button>
                            @endfor
                        </div>
                        <input type="hidden" name="avaliacao" id="avaliacao" value="{{ old('avaliacao', 0) }}">
                        @error('avaliacao')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        <div class="form-text">Clique para definir de 1 a 5 estrelas.</div>
                    </div>
                    <div class="mb-3">
                        <label for="conteudo" class="form-label fw-semibold">Resenha *</label>
                        <textarea name="conteudo" id="conteudo" rows="10" class="form-control" placeholder="Compartilhe suas impressões sobre o livro..." required>{{ old('conteudo') }}</textarea>
                        <div class="d-flex justify-content-between mt-1 small">
                            <span id="char-count" class="text-muted">0 caracteres</span>
                            <span class="text-muted">Mínimo: 10</span>
                        </div>
                        @error('conteudo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="spoiler" name="spoiler" value="1" {{ old('spoiler') ? 'checked' : '' }}>
                        <label class="form-check-label" for="spoiler">Esta resenha contém spoilers</label>
                    </div>
                    <div class="d-flex gap-2 mt-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i>Publicar</button>
                        <a href="{{ route('resenhas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="p-3 border rounded h-100 bg-light" style="min-height:160px;">
                        <h2 class="h6 fw-semibold mb-2"><i class="fas fa-eye me-1 text-warning"></i>Pré-visualização</h2>
                        <div id="preview-spoiler" class="mb-2" style="display:none;">
                            <span class="badge bg-danger"><i class="fas fa-exclamation-triangle me-1"></i>Spoiler</span>
                        </div>
                        <div id="preview-conteudo" class="small" style="white-space:pre-line; color:var(--old-ink);"></div>
                    </div>
                    <div class="mt-3 small text-muted">
                        <ul class="mb-2 ps-3" style="list-style:disc;">
                            <li>Seja honesto e respeitoso.</li>
                            <li>Use a pré-visualização para revisar.</li>
                            <li>Marque spoilers quando necessário.</li>
                        </ul>
                        <p class="mb-0"><i class="fas fa-info-circle me-1"></i>Avaliação opcional.</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Estrelas de avaliação
(function(){
  const stars = document.querySelectorAll('#avaliacao-stars .rating-star');
  const input = document.getElementById('avaliacao');
  function paint(r){
    stars.forEach(s=>{
      const val = parseInt(s.getAttribute('data-rating'));
      if(val <= r){ s.textContent='★'; s.classList.add('text-warning'); s.setAttribute('data-active','1'); }
      else { s.textContent='☆'; s.classList.remove('text-warning'); s.setAttribute('data-active','0'); }
    });
  }
  stars.forEach(s=>{
    s.addEventListener('click',()=>{ const r=parseInt(s.getAttribute('data-rating')); input.value=r; paint(r); });
    s.addEventListener('keydown',e=>{ if(['Enter',' '].includes(e.key)){ e.preventDefault(); const r=parseInt(s.getAttribute('data-rating')); input.value=r; paint(r);} });
    s.setAttribute('tabindex','0');
  });
  const old = parseInt(input.value||'0'); if(old>0) paint(old);
})();

// Pré-visualização da resenha + contador
(function(){
  const txt = document.getElementById('conteudo');
  const prev = document.getElementById('preview-conteudo');
  const count = document.getElementById('char-count');
  const spoiler = document.getElementById('spoiler');
  const spoilerBadge = document.getElementById('preview-spoiler');
  function update(){
     prev.textContent = txt.value.trim();
     count.textContent = txt.value.length + ' caracteres';
     spoilerBadge.style.display = spoiler.checked ? 'block':'none';
  }
  ['input','change'].forEach(ev=>txt.addEventListener(ev, update));
  spoiler.addEventListener('change', update);
  update();
})();
</script>
@endpush
@endsection