@extends('layouts.app')

@section('content')
<div class="parchment-panel soft-shadow mb-4">
    <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
        <div>
            <h1 class="h4 brand-font mb-1" style="color: var(--old-ink);"><i class="fas fa-book me-2" style="color:var(--old-accent);"></i>Editar Livro</h1>
            <div class="small text-muted">Atualize os metadados, autores e capa do livro.</div>
        </div>
        <div class="d-flex gap-2 mt-2 mt-sm-0">
            <a href="{{ route('livros.show', $livro->id) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye me-1"></i>Ver</a>
            <a href="{{ route('livros.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Voltar</a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger small">
            <strong>Erros ao salvar:</strong>
            <ul class="m-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('livros.update', $livro->id) }}" enctype="multipart/form-data" id="livro-edit-form">
        @method('PUT')
        @include('livros._form')
    </form>
</div>
@endsection
