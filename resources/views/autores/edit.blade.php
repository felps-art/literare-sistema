@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('autores.update', $autor->id) }}" class="mb-4">
    @method('PUT')
    @include('autores._form')
</form>
@endsection
