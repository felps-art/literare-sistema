@csrf
@php($isEdit = isset($autor))
<div class="parchment-panel soft-shadow mb-3">
    <h2 class="h5 brand-font mb-2"><i class="fas fa-feather-alt me-2"></i>{{ $isEdit ? 'Editar Autor' : 'Cadastrar Autor' }}</h2>
    <p class="text-muted small m-0">Campos obrigatórios marcados com * | Código usado como identificador único.</p>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong><i class="fas fa-exclamation-triangle me-1"></i>Erros encontrados:</strong>
        <ul class="mb-0 mt-2 small">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card mb-4">
    <div class="card-body">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome *</label>
            <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $autor->nome ?? '') }}" placeholder="Ex: Machado de Assis" required>
            @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="codigo" class="form-label">Código Único *</label>
            <input type="text" name="codigo" id="codigo" class="form-control @error('codigo') is-invalid @enderror" value="{{ old('codigo', $autor->codigo ?? '') }}" placeholder="ex: machado-assis" required>
            <div class="form-text">Gerado automaticamente a partir do nome se você não alterar.</div>
            @error('codigo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="biografia" class="form-label">Biografia</label>
            <textarea name="biografia" id="biografia" rows="5" class="form-control @error('biografia') is-invalid @enderror" placeholder="Resumo da carreira, prêmios, estilo literário...">{{ old('biografia', $autor->biografia ?? '') }}</textarea>
            @error('biografia')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <div class="small text-muted mt-1"><span id="bio-count">0</span> caracteres</div>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ isset($autor) ? route('autores.show',$autor) : route('autores.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Cancelar</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i>{{ $isEdit ? 'Atualizar' : 'Salvar' }}
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function(){
    const nome = document.getElementById('nome');
    const codigo = document.getElementById('codigo');
    const bio = document.getElementById('biografia');
    const bioCount = document.getElementById('bio-count');
    const userEditedCodigo = !!codigo.value.trim();
    function slugify(str){
        return str
            .toLowerCase()
            .normalize('NFD').replace(/\p{Diacritic}/gu,'')
            .replace(/[^a-z0-9]+/g,'-')
            .replace(/^-+|-+$/g,'')
            .substring(0,100);
    }
    if(nome){
        nome.addEventListener('input',()=>{
            if(!userEditedCodigo && (!codigo.value || codigo.dataset.autofill==='1')){
                codigo.dataset.autofill='1';
                codigo.value = slugify(nome.value);
            }
        });
    }
    if(codigo){
        codigo.addEventListener('input',()=>{codigo.dataset.autofill='0';});
    }
    if(bio && bioCount){
        const updateCount=()=>{bioCount.textContent=bio.value.length};
        bio.addEventListener('input',updateCount);updateCount();
    }
})();
</script>
@endpush
