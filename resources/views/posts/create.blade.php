@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Novo Post</h1>
<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
    @include('posts._form')
</form>
@endsection
