@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Nova Editora</h1>
<form action="{{ route('editoras.store') }}" method="POST" class="bg-white p-6 rounded shadow">
    @include('editoras._form')
</form>
@endsection
