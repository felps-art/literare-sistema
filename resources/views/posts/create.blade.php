@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-bottom-0 py-3 d-flex justify-content-between align-items-center">
                    <h1 class="h5 brand-font m-0" style="color:var(--old-ink);">
                        <i class="fas fa-feather-alt me-2 text-primary"></i>Novo Post
                    </h1>
                    <a href="{{ route('posts.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Voltar
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="post-create-form">
                        @include('posts._form')
                    </form>
                </div>
            </div>
            <div class="card border-0 shadow-sm" id="live-preview-wrapper" style="display:none;">
                <div class="card-header bg-white border-bottom-0 py-2">
                    <strong class="brand-font" style="font-size:1rem;">
                        <i class="fas fa-eye me-1 text-warning"></i>Pré-visualização
                    </strong>
                </div>
                <div class="card-body">
                    <div id="live-preview" class="text-muted" style="white-space:pre-line; min-height:60px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="card-title m-0">
                        <i class="fas fa-lightbulb text-warning me-2"></i>Dicas
                    </h5>
                </div>
                <div class="card-body small text-muted">
                    <ul class="mb-2 ps-3" style="list-style:disc;">
                        <li>Mantenha o conteúdo claro e objetivo.</li>
                        <li>Use a pré-visualização para revisar antes de publicar.</li>
                        <li>Imagens ajudam a engajamento (limite 4MB cada).</li>
                    </ul>
                    <p class="mb-1"><i class="fas fa-info-circle me-1"></i>Limite de caracteres: <strong>5000</strong>.</p>
                    <p class="mb-0"><i class="fas fa-shield-alt me-1"></i>Respeite as regras da comunidade.</p>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
    (function(){
        const textarea = document.querySelector('textarea[name="content"]');
        const previewWrapper = document.getElementById('live-preview-wrapper');
        const preview = document.getElementById('live-preview');
        if(!textarea || !preview) return;
        const toggle = () => {
            const val = textarea.value.trim();
            if(val.length){
                previewWrapper.style.display = 'block';
                preview.textContent = val;
            } else {
                previewWrapper.style.display = 'none';
                preview.textContent = '';
            }
        };
        textarea.addEventListener('input', toggle);
        toggle();
    })();
    </script>
    @endpush
@endsection
