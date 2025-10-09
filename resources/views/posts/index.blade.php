@extends('layouts.app')

@section('content')
    <div class="parchment-panel soft-shadow mb-3 d-flex justify-content-between align-items-center">
        <h1 class="h5 brand-font m-0" style="color:var(--old-ink);">
            <i class="fas fa-comments me-2" style="color:var(--old-accent);"></i>Posts
        </h1>
        <a href="{{ route('posts.create') }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-plus me-1"></i>Novo Post
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @forelse($posts as $post)
        <div class="parchment-panel soft-shadow mb-3">
            <div class="d-flex justify-content-between small text-muted mb-2">
                <span>por <a href="{{ route('profile.show',$post->user_id) }}" class="text-decoration-none">{{ $post->user->name }}</a></span>
                <span>{{ $post->created_at->diffForHumans() }}</span>
            </div>
            <div class="mb-2" style="white-space:pre-line; color:var(--old-ink);">{{ Str::limit($post->content, 300) }}</div>
            @if($post->photos->count())
                <div class="row g-2 mb-2">
                    @foreach($post->photos->take(4) as $photo)
                        <div class="col-6 col-md-3">
                            <img src="{{ $photo->url }}" class="img-fluid rounded" style="height:130px; object-fit:cover; width:100%;"/>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center mt-2">
                <a href="{{ route('posts.show',$post) }}" class="small text-decoration-none">
                    <i class="fas fa-eye me-1"></i>Ver mais
                </a>
                <div class="d-flex align-items-center gap-3">
                    <span class="small text-muted">
                        <i class="fas fa-comment me-1"></i>{{ $post->comments->count() }}
                    </span>
                    @auth
                        <button
                            class="btn btn-sm {{ $post->isLikedBy(auth()->user()) ? 'btn-outline-danger' : 'btn-outline-secondary' }}"
                            data-like
                            data-type="post"
                            data-id="{{ $post->id }}"
                            data-state="{{ $post->isLikedBy(auth()->user()) ? 'liked' : 'unliked' }}"
                        >
                            <i class="{{ $post->isLikedBy(auth()->user()) ? 'fas fa-heart text-danger' : 'far fa-heart' }}"></i>
                            <span class="ms-1" data-like-count>{{ $post->likesCount() }}</span>
                        </button>
                    @endauth
                    @guest
                        <span class="small text-muted">
                            <i class="far fa-heart"></i>
                            <span class="ms-1">{{ $post->likesCount() }}</span>
                        </span>
                    @endguest
                </div>
            </div>
        </div>
    @empty
        <div class="parchment-panel soft-shadow text-center text-muted">Nenhum post encontrado.</div>
    @endforelse

    <div class="mt-3">{{ $posts->links() }}</div>
@endsection
