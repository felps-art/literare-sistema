@csrf
<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Título *</label>
        <input type="text" name="titulo" value="{{ old('titulo', $livro->titulo ?? '') }}" placeholder="Ex.: Dom Casmurro" required class="form-control form-control-sm" />
        @error('titulo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label small fw-semibold">Código *</label>
        <input type="text" name="codigo_livro" value="{{ old('codigo_livro', $livro->codigo_livro ?? '') }}" placeholder="ISBN ou código interno" required class="form-control form-control-sm" />
        @error('codigo_livro')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label small fw-semibold">Ano Publicação</label>
        <input type="number" name="ano_publicacao" value="{{ old('ano_publicacao', $livro->ano_publicacao ?? '') }}" placeholder="Ex.: 1997" class="form-control form-control-sm" />
        @error('ano_publicacao')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label small fw-semibold">Páginas</label>
        <input type="number" name="numero_paginas" value="{{ old('numero_paginas', $livro->numero_paginas ?? '') }}" placeholder="Ex.: 320" class="form-control form-control-sm" />
        @error('numero_paginas')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label small fw-semibold">Editora *</label>
        <select name="editora_id" required class="form-select form-select-sm">
            <option value="">Selecione</option>
            @foreach($editoras as $editora)
                <option value="{{ $editora->id }}" @selected(old('editora_id', $livro->editora_id ?? '') == $editora->id)>{{ $editora->nome }}</option>
            @endforeach
        </select>
        @error('editora_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Autores *</label>
        @php $selectedAutores = old('autores', isset($livro) ? $livro->autores->pluck('id')->toArray() : []); @endphp
        <select name="autores[]" multiple required size="6" class="form-select">
            @foreach($autores as $autor)
                <option value="{{ $autor->id }}" @selected(in_array($autor->id, $selectedAutores))>{{ $autor->nome }}</option>
            @endforeach
        </select>
        <div class="form-text">Use CTRL/SHIFT para selecionar múltiplos autores.</div>
        @error('autores')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-9">
        <label class="form-label small fw-semibold d-flex justify-content-between"> <span>Sinopse</span> <span class="small text-muted" id="sinopse-counter"></span></label>
        <textarea name="sinopse" rows="6" class="form-control" id="sinopse-text" placeholder="Escreva um breve resumo do livro...">{{ old('sinopse', $livro->sinopse ?? '') }}</textarea>
        @error('sinopse')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label small fw-semibold">Imagem da Capa</label>
        <input type="file" name="imagem_capa" accept="image/*" class="form-control form-control-sm" id="capa-input" />
        <div class="ratio ratio-2x3 mt-2 border rounded position-relative" style="--bs-aspect-ratio:150%; background:#f5ecd9;">
            @if(isset($livro) && $livro->imagem_capa)
                <img src="{{ asset('storage/' . $livro->imagem_capa) }}" class="w-100 h-100 object-fit-cover rounded" id="capa-preview" />
            @else
                <div class="d-flex flex-column justify-content-center align-items-center h-100 text-muted small" id="capa-placeholder">
                    <i class="fas fa-image mb-1"></i>
                    <span>Prévia</span>
                </div>
                <img src="" class="w-100 h-100 object-fit-cover rounded d-none" id="capa-preview" />
            @endif
        </div>
        <div class="form-text">Dica: imagens verticais ficam melhores (proporção ~2:3).</div>
        @error('imagem_capa')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    </div>
</div>
<div class="mt-4 d-flex justify-content-end gap-2">
    @if(auth()->check() && auth()->user()->is_admin)
        <a href="{{ route('livros.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Cancelar</a>
    @else
        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Cancelar</a>
    @endif
    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save me-1"></i>Salvar</button>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const sinopse = document.getElementById('sinopse-text');
    const counter = document.getElementById('sinopse-counter');
    const maxChars = 2000;
    function updateCounter(){
        if(!sinopse) return;
        const len = sinopse.value.length;
        counter.textContent = len + '/' + maxChars;
        counter.classList.toggle('text-danger', len > maxChars);
    }
    sinopse?.addEventListener('input', updateCounter);
    updateCounter();

    const input = document.getElementById('capa-input');
    const preview = document.getElementById('capa-preview');
    const placeholder = document.getElementById('capa-placeholder');
    input?.addEventListener('change', (e) => {
        const file = e.target.files?.[0];
        if(!file) return;
        const url = URL.createObjectURL(file);
        preview.src = url;
        preview.classList.remove('d-none');
        placeholder?.classList.add('d-none');
    });
});
</script>
@endpush
