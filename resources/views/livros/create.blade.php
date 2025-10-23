@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 brand-font mb-1" style="color: var(--old-ink);">
                <i class="fas fa-book-open me-2" style="color: var(--old-accent);"></i>
                Cadastrar Livro
            </h1>
            <span class="text-muted small">Adicione um novo livro ao catálogo</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('livros.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Voltar
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-start">
                <i class="fas fa-exclamation-circle me-2 mt-1"></i>
                <div>
                    <strong class="d-block mb-1">Corrija os campos destacados abaixo:</strong>
                    <ul class="m-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li class="small">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="parchment-panel soft-shadow">
        <form method="POST" action="{{ route('livros.store') }}" enctype="multipart/form-data" id="livro-create-form">
            @include('livros._form')
        </form>
    </div>
@endsection
