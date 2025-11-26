@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 760px;">
    <div class="parchment-panel soft-shadow mb-3">
        <h1 class="h5 brand-font m-0"><i class="fas fa-user-edit me-2"></i>Editar Perfil</h1>
        <div class="small text-muted">Atualize seu nome, e-mail e foto de perfil</div>
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

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="form-control @error('name') is-invalid @enderror">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="form-control @error('email') is-invalid @enderror">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto de Perfil</label>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        @if($user->foto_perfil)
                            <img src="{{ asset('storage/' . $user->foto_perfil) }}" class="rounded-circle" width="64" height="64" style="object-fit:cover;" alt="Avatar" />
                        @else
                            <span class="badge bg-secondary rounded-circle" style="width:64px;height:64px; display:inline-flex;align-items:center;justify-content:center; font-size:1.6rem;">{{ substr($user->name,0,1) }}</span>
                        @endif
                        <input id="foto_perfil" type="file" name="foto_perfil" accept="image/*" class="form-control @error('foto_perfil') is-invalid @enderror" style="max-width: 320px;">
                        @error('foto_perfil')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-text">Formatos permitidos: jpeg, png, jpg, gif. Tamanho máximo: 5MB.</div>
                    <div id="foto-size-error" class="text-danger small mt-1 d-none"><i class="fas fa-exclamation-triangle me-1"></i>O arquivo selecionado excede 5MB. Escolha uma imagem menor.</div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('profile.show', $user->id) }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Cancelar</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function(){
    const input = document.getElementById('foto_perfil');
    const errorEl = document.getElementById('foto-size-error');
    const MAX = 5 * 1024 * 1024; // 5MB
    if(!input) return;
    function check(){
        if(!input.files || !input.files[0]){ errorEl?.classList.add('d-none'); return true; }
        const ok = input.files[0].size <= MAX;
        if(!ok){
            if(errorEl){ errorEl.classList.remove('d-none'); }
        } else {
            if(errorEl){ errorEl.classList.add('d-none'); }
        }
        return ok;
    }
    input.addEventListener('change', () => {
        if(!check()){ input.value=''; }
    });
    const form = input.closest('form');
    form?.addEventListener('submit', (e) => { if(!check()){ e.preventDefault(); } });
})();
</script>
@endpush
