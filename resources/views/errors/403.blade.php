@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height:60vh;">
    <div class="text-center">
        <h1 class="display-4 text-danger">403 — Acesso negado</h1>
        <p class="lead">Você não tem permissão para acessar esta página.</p>
        @auth
            <p>Se você acha que deveria ter acesso, contate um administrador.</p>
        @else
            <p>Por favor, faça login com uma conta que possua privilégios de administrador.</p>
            <a href="{{ route('login') }}" class="btn btn-primary">Entrar</a>
        @endauth
        <div class="mt-4">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Voltar</a>
            <a href="{{ route('dashboard.home') }}" class="btn btn-link">Ir para página inicial</a>
        </div>
    </div>
</div>
@endsection
