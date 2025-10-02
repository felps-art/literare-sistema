@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Editar Editora</h1>
<form action="{{ route('editoras.update',$editora) }}" method="POST" class="bg-white p-6 rounded shadow">
    @csrf
    @method('PUT')
    @include('editoras._form')
</form>
@endsection
