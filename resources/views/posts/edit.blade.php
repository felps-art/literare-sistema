@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Editar Post</h1>
<form action="{{ route('posts.update',$post) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
    @csrf
    @method('PUT')
    @include('posts._form')
</form>
@endsection
