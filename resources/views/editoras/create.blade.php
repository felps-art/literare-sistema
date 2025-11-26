@extends('layouts.app')

@section('content')
<form action="{{ route('editoras.store') }}" method="POST" class="mb-4">
    @include('editoras._form')
</form>
@endsection
