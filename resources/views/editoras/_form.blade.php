@csrf
@php($isEdit = isset($editora))
<div class="parchment-panel soft-shadow mb-3">
    <h2 class="h5 brand-font mb-2"><i class="fas fa-building me-2"></i>{{ $isEdit ? 'Editar Editora' : 'Cadastrar Editora' }}</h2>
    <p class="text-muted small m-0">Informe o nome oficial. Campos obrigatórios marcados com *.</p>
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
            <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $editora->nome ?? '') }}" placeholder="Ex: Companhia das Letras" required>
            @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ isset($editora) ? route('editoras.show',$editora) : route('editoras.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>{{ $isEdit ? 'Atualizar' : 'Salvar' }}</button>
        </div>
    </div>
</div>
