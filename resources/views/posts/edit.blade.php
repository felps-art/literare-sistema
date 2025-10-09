@extends('layouts.app')

@section('content')
    <div class="parchment-panel soft-shadow mb-3 d-flex justify-content-between align-items-center">
        <h1 class="h5 brand-font m-0" style="color:var(--old-ink);"><i class="fas fa-edit me-2" style="color:var(--old-accent);"></i>Editar Post</h1>
    </div>
    <div class="parchment-panel soft-shadow">
        <form action="{{ route('posts.update',$post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('posts._form')
        </form>
    </div>
@endsection
