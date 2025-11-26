@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Cabeçalho -->
    <div class="parchment-panel soft-shadow mb-3 d-flex align-items-center gap-3">
        @if($user->foto_perfil)
            <img class="rounded-circle" width="64" height="64" style="object-fit:cover;" src="{{ asset('storage/' . $user->foto_perfil) }}" alt="{{ $user->name }}">
        @else
            <span class="badge bg-secondary rounded-circle" style="width:64px;height:64px; display:inline-flex;align-items:center;justify-content:center; font-size:1.6rem;">{{ substr($user->name, 0, 1) }}</span>
        @endif
        <div>
            <h1 class="h5 brand-font m-0" style="color:var(--old-ink);">Publicações de {{ $user->name }}</h1>
            <div class="small text-muted">{{ $posts->total() }} publicações no total</div>
        </div>
    </div>

    <!-- Lista de publicações -->
    <div class="parchment-panel soft-shadow">
        @if($posts->count() > 0)
            @foreach($posts as $post)
                <article class="border-bottom pb-3 mb-3 @if($loop->last) border-0 mb-0 pb-0 @endif">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="small text-muted">
                                por <a href="{{ route('profile.show', $post->user->id) }}" class="text-muted text-decoration-none">{{ $post->user->name }}</a> · {{ $post->created_at->format('d/m/Y \à\s H:i') }}
                            </div>
                        </div>
                    </div>
                    
                    {{-- Conteúdo do Post --}}
                    <div class="text-muted mb-2" style="white-space: pre-line;">{{ $post->content }}</div>

                    {{-- Fotos do Post --}}
                    @if($post->photos->isNotEmpty())
                        <div class="row g-2 mb-2">
                            @foreach($post->photos as $photo)
                                <div class="col-4">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" class="img-fluid rounded" alt="Foto do post">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mt-2 small">
                        <div class="d-flex align-items-center gap-3">
                            {{-- Likes --}}
                            <a href="#" class="text-muted text-decoration-none"
                               data-like data-type="post" data-id="{{ $post->id }}" 
                               data-state="{{ auth()->user()->likedPosts->contains($post->id) ? 'liked' : 'unliked' }}">
                                <i class="{{ auth()->user()->likedPosts->contains($post->id) ? 'fas fa-heart text-danger' : 'far fa-heart' }}"></i>
                                <span data-like-count>{{ $post->likes->count() }}</span>
                            </a>
                            {{-- Comentários --}}
                            <a href="{{ route('posts.show', $post->id) }}#comments" class="text-muted text-decoration-none">
                                <i class="fas fa-comment me-1"></i>{{ $post->comments->count() }}
                            </a>
                        </div>
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-outline-primary">Ver Post →</a>
                    </div>
                </article>
            @endforeach

            <div class="d-flex justify-content-center">{{ $posts->links() }}</div>
        @else
            <div class="text-center py-5">
                <div class="display-6 mb-2">📝</div>
                <h5 class="text-muted">Nenhuma publicação encontrada</h5>
                <p class="text-muted">Este usuário ainda não fez nenhuma publicação.</p>
            </div>
        @endif
    </div>
</div>
@endsection