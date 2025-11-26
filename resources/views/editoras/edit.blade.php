@extends('layouts.app')

@section('content')
<form action="{{ route('editoras.update',$editora) }}" method="POST" class="mb-4">
    @csrf
    @method('PUT')
    @include('editoras._form')
</form>
@endsection
