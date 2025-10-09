@extends('layouts.app')

@section('content')
<div class="container">
    <div class="parchment-panel soft-shadow mb-3 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h5 brand-font m-0" style="color:var(--old-ink);"><i class="fas fa-users me-2"></i>Todos os Usuários</h1>
            <div class="small text-muted">Encontre leitores com interesses similares</div>
        </div>
        <span class="badge bg-secondary">{{ $users->total() }}</span>
    </div>

    <div class="parchment-panel soft-shadow p-0">
        @foreach($users as $user)
            <div class="p-3 border-bottom @if($loop->last) border-0 @endif">
                <div class="row align-items-center g-3">
                    <div class="col-auto">
                        @if($user->foto_perfil)
                            <img class="rounded-circle" width="52" height="52" style="object-fit: cover;" src="{{ asset('storage/' . $user->foto_perfil) }}" alt="{{ $user->name }}">
                        @else
                            <span class="badge bg-secondary rounded-circle" style="width:52px;height:52px; display:inline-flex;align-items:center;justify-content:center; font-size:1.2rem;">{{ substr($user->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="col">
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none" style="color:var(--old-ink);"><strong>{{ $user->name }}</strong></a>
                        <div class="small text-muted">{{ $user->email }}</div>
                        <div class="d-flex gap-3 small text-muted mt-1">
                            <span><i class="fas fa-users me-1"></i>{{ $user->followersCount() }} seguidores</span>
                            <span><i class="fas fa-star me-1"></i>{{ $user->resenhas_count }} resenhas</span>
                            <span><i class="fas fa-bookmark me-1"></i>{{ $user->livros_status_count }} livros</span>
                        </div>
                    </div>
                    <div class="col-auto d-flex gap-2">
                        @auth
                            @if(auth()->id() !== $user->id)
                                @if(auth()->user()->isFollowing($user))
                                    <form action="{{ route('users.unfollow', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-user-minus me-1"></i>Seguindo</button>
                                    </form>
                                @else
                                    <form action="{{ route('users.follow', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success"><i class="fas fa-user-plus me-1"></i>Seguir</button>
                                    </form>
                                @endif
                            @endif
                        @endauth
                        <a href="{{ route('profile.show', $user->id) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye me-1"></i>Ver Perfil</a>
                    </div>
                </div>
            </div>
        @endforeach

        @if($users->hasPages())
            <div class="p-2 d-flex justify-content-center">{{ $users->links() }}</div>
        @endif
    </div>
</div>
@endsection