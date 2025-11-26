@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('autores.store') }}" class="mb-4">
    @include('autores._form')
</form>
@endsection
