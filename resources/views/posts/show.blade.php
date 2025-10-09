@extends('layouts.app')

@section('content')
    <div class="parchment-panel soft-shadow mb-3 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h5 brand-font m-0" style="color:var(--old-ink);">
                <i class="fas fa-comment-dots me-2" style="color:var(--old-accent);"></i>
                Post de <a href="{{ route('profile.show',$post->user_id) }}" class="text-decoration-none">{{ $post->user->name }}</a>
            </h1>
            <div class="small text-muted">{{ $post->created_at->diffForHumans() }}</div>
        </div>
        <div class="d-flex gap-2">
            @if(auth()->check() && $post->user_id === auth()->id())
                <a href="{{ route('posts.edit',$post) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit me-1"></i>Editar</a>
                <form action="{{ route('posts.destroy',$post) }}" method="POST" onsubmit="return confirm('Excluir este post?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash me-1"></i>Excluir</button>
                </form>
            @endif
            <a href="{{ route('posts.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Voltar</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="parchment-panel soft-shadow mb-3">
        <div style="white-space:pre-line; color:var(--old-ink);">{{ $post->content }}</div>
        @if($post->photos->count())
            <div class="row g-2 mt-2">
                @foreach($post->photos as $photo)
                    <div class="col-6 col-md-3">
                        <img src="{{ $photo->url }}" class="img-fluid rounded" style="height:160px; object-fit:cover; width:100%;"/>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="small text-muted"><i class="fas fa-comment me-1"></i>{{ $post->comments->count() }}</div>
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
            @else
                <span class="small text-muted">
                    <i class="far fa-heart"></i><span class="ms-1">{{ $post->likesCount() }}</span>
                </span>
            @endauth
        </div>
    </div>

    <div class="parchment-panel soft-shadow">
        <h2 class="h6 brand-font mb-3" style="color:var(--old-ink);">Comentários ({{ $post->comments->count() }})</h2>
        <div class="mb-3">
            @forelse($post->comments as $comment)
                <div class="border-bottom pb-2 mb-2">
                    <div class="d-flex justify-content-between align-items-start small text-muted">
                        <div>{{ $comment->user->name }} · {{ $comment->created_at->diffForHumans() }}</div>
                        @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->id() === $post->user_id))
                            <form action="{{ route('comments.destroy',$comment) }}" method="POST" onsubmit="return confirm('Remover este comentário?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-link btn-sm text-danger p-0">Remover</button>
                            </form>
                        @endif
                    </div>
                    <div style="white-space:pre-line; color:var(--old-ink);">{{ $comment->content }}</div>
                </div>
            @empty
                <div class="text-muted small">Nenhum comentário ainda.</div>
            @endforelse
        </div>

        @auth
            <form action="{{ route('posts.comments.store',$post) }}" method="POST" class="mt-2">
                @csrf
                <div class="mb-2">
                    <textarea name="content" rows="3" class="form-control" placeholder="Escreva um comentário..." required>{{ old('content') }}</textarea>
                    @error('content')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <button class="btn btn-sm btn-primary"><i class="fas fa-paper-plane me-1"></i>Comentar</button>
            </form>
        @else
            <p class="small text-muted">Faça <a href="{{ route('login') }}">login</a> para comentar.</p>
        @endauth
    </div>
@endsection
