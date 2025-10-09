@extends('layouts.app')

@section('content')
    <div class="parchment-panel soft-shadow mb-3 d-flex justify-content-between align-items-center">
        <h1 class="h5 brand-font m-0" style="color:var(--old-ink);">
            <i class="fas fa-compass me-2" style="color:var(--old-accent);"></i>Explorar
        </h1>
        <span class="text-muted small">Feed geral (sem personalização)</span>
    </div>

    <form method="get" action="{{ route('explorar') }}" class="parchment-panel soft-shadow mb-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small text-muted">Tag/termo</label>
                <input type="text" name="tag" value="{{ $filters['tag'] ?? '' }}" class="form-control" placeholder="#fantasia ou palavra-chave" />
            </div>
            <div class="col-md-4">
                <label class="form-label small text-muted">Livro</label>
                <select name="livro_id" class="form-select">
                    <option value="">Todos os livros</option>
                    @foreach(($livrosOptions ?? collect()) as $livro)
                        <option value="{{ $livro->id }}" @selected(($filters['livro_id'] ?? null) == $livro->id)>{{ $livro->titulo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Período</label>
                <select name="period" class="form-select">
                    @php($period = $filters['period'] ?? '24h')
                    <option value="24h" @selected($period==='24h')>Últimas 24h</option>
                    <option value="7d" @selected($period==='7d')>Últimos 7 dias</option>
                    <option value="30d" @selected($period==='30d')>Últimos 30 dias</option>
                    <option value="all" @selected($period==='all')>Tudo</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <input type="hidden" name="tab" value="{{ $tab ?? 'todos' }}" />
                <button class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i>Aplicar</button>
                <a href="{{ route('explorar') }}" class="btn btn-outline-secondary" title="Limpar filtros"><i class="fas fa-times"></i></a>
            </div>
        </div>
    </form>

    <ul class="nav nav-tabs mb-3" role="tablist">
        @php($currentTab = $tab ?? 'todos')
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $currentTab==='todos' ? 'active' : '' }}" id="todos-tab" data-bs-toggle="tab" data-bs-target="#todos" type="button" role="tab" aria-selected="{{ $currentTab==='todos' ? 'true' : 'false' }}">
                <i class="fas fa-stream me-1"></i>Todos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $currentTab==='posts' ? 'active' : '' }}" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts" type="button" role="tab" aria-selected="{{ $currentTab==='posts' ? 'true' : 'false' }}">
                <i class="fas fa-comments me-1"></i>Posts
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $currentTab==='resenhas' ? 'active' : '' }}" id="resenhas-tab" data-bs-toggle="tab" data-bs-target="#resenhas" type="button" role="tab" aria-selected="{{ $currentTab==='resenhas' ? 'true' : 'false' }}">
                <i class="fas fa-book-open me-1"></i>Resenhas
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $currentTab==='trending' ? 'active' : '' }}" id="trending-tab" data-bs-toggle="tab" data-bs-target="#trending" type="button" role="tab" aria-selected="{{ $currentTab==='trending' ? 'true' : 'false' }}">
                <i class="fas fa-bolt me-1"></i>Em alta
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade {{ $currentTab==='todos' ? 'show active' : '' }}" id="todos" role="tabpanel" aria-labelledby="todos-tab">
            @forelse(($combined ?? collect()) as $item)
                @if(($item->kind ?? null) === 'post')
                    <div class="parchment-panel soft-shadow mb-3">
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>por <a href="{{ route('profile.show',$item->user_id) }}" class="text-decoration-none">{{ $item->user->name }}</a></span>
                            <span>{{ $item->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="mb-2" style="white-space:pre-line; color:var(--old-ink);">{{ Str::limit($item->content, 300) }}</div>
                        @if($item->photos->count())
                            <div class="row g-2 mb-2">
                                @foreach($item->photos->take(4) as $photo)
                                    <div class="col-6 col-md-3">
                                        <img src="{{ $photo->url }}" class="img-fluid rounded" style="height:130px; object-fit:cover; width:100%;"/>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <a href="{{ route('posts.show',$item) }}" class="small text-decoration-none">
                                <i class="fas fa-eye me-1"></i>Ver mais
                            </a>
                            <div class="d-flex align-items-center gap-3">
                                <span class="small text-muted">
                                    <i class="fas fa-comment me-1"></i>{{ $item->comments_count ?? $item->comments->count() }}
                                </span>
                                @auth
                                    <button
                                        class="btn btn-sm {{ method_exists($item,'isLikedBy') && $item->isLikedBy(auth()->user()) ? 'btn-outline-danger' : 'btn-outline-secondary' }}"
                                        data-like data-type="post" data-id="{{ $item->id }}"
                                        data-state="{{ method_exists($item,'isLikedBy') && $item->isLikedBy(auth()->user()) ? 'liked' : 'unliked' }}"
                                    >
                                        <i class="{{ method_exists($item,'isLikedBy') && $item->isLikedBy(auth()->user()) ? 'fas fa-heart text-danger' : 'far fa-heart' }}"></i>
                                        <span class="ms-1" data-like-count>{{ $item->likes_rel_count ?? ($item->likes_count ?? $item->likes->count()) }}</span>
                                    </button>
                                @endauth
                                @guest
                                    <span class="small text-muted">
                                        <i class="far fa-heart"></i>
                                        <span class="ms-1">{{ $item->likes_rel_count ?? ($item->likes_count ?? $item->likes->count()) }}</span>
                                    </span>
                                @endguest
                            </div>
                        </div>
                    </div>
                @else
                    <div class="parchment-panel soft-shadow mb-3">
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>por <a href="{{ route('profile.show',$item->user_id) }}" class="text-decoration-none">{{ $item->user->name }}</a></span>
                            <span>{{ $item->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="mb-1">
                            <a href="{{ route('livros.show',$item->livro_id) }}" class="text-decoration-none fw-semibold">{{ $item->livro->titulo }}</a>
                            @if($item->avaliacao)
                                <span class="badge bg-warning text-dark ms-2"><i class="fas fa-star me-1"></i>{{ $item->avaliacao }}/5</span>
                            @endif
                        </div>
                        <div class="text-muted small mb-2">{{ Str::limit(strip_tags($item->conteudo), 280) }}</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('resenhas.show',$item) }}" class="small text-decoration-none"><i class="fas fa-eye me-1"></i>Ler resenha</a>
                            <div class="d-flex align-items-center gap-3">
                                <span class="small text-muted"><i class="fas fa-comment me-1"></i>{{ $item->comments_count ?? $item->comments->count() }}</span>
                                @auth
                                    <button
                                        class="btn btn-sm {{ method_exists($item,'isLikedBy') && $item->isLikedBy(auth()->user()) ? 'btn-outline-danger' : 'btn-outline-secondary' }}"
                                        data-like data-type="resenha" data-id="{{ $item->id }}"
                                        data-state="{{ method_exists($item,'isLikedBy') && $item->isLikedBy(auth()->user()) ? 'liked' : 'unliked' }}"
                                    >
                                        <i class="{{ method_exists($item,'isLikedBy') && $item->isLikedBy(auth()->user()) ? 'fas fa-heart text-danger' : 'far fa-heart' }}"></i>
                                        <span class="ms-1" data-like-count>{{ $item->likes_rel_count ?? ($item->likes_count ?? $item->likes->count()) }}</span>
                                    </button>
                                @endauth
                                @guest
                                    <span class="small text-muted">
                                        <i class="far fa-heart"></i>
                                        <span class="ms-1">{{ $item->likes_rel_count ?? ($item->likes_count ?? $item->likes->count()) }}</span>
                                    </span>
                                @endguest
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="parchment-panel soft-shadow text-center text-muted">Nada encontrado.</div>
            @endforelse

            @if(($nextCursor ?? null))
                @php(
                    $q = [
                        'tab' => 'todos',
                        'cursor' => $nextCursor,
                        'tag' => $filters['tag'] ?? null,
                        'livro_id' => $filters['livro_id'] ?? null,
                        'period' => $filters['period'] ?? null,
                    ]
                )
                <div class="text-center">
                    <a class="btn btn-outline-primary" href="{{ route('explorar', $q) }}">
                        <i class="fas fa-arrow-down me-1"></i>Carregar mais
                    </a>
                </div>
            @endif
        </div>

        <div class="tab-pane fade {{ $currentTab==='posts' ? 'show active' : '' }}" id="posts" role="tabpanel" aria-labelledby="posts-tab">
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
                                <i class="fas fa-comment me-1"></i>{{ $post->comments_count ?? $post->comments->count() }}
                            </span>
                            @auth
                                <button
                                    class="btn btn-sm {{ method_exists($post,'isLikedBy') && $post->isLikedBy(auth()->user()) ? 'btn-outline-danger' : 'btn-outline-secondary' }}"
                                    data-like data-type="post" data-id="{{ $post->id }}"
                                    data-state="{{ method_exists($post,'isLikedBy') && $post->isLikedBy(auth()->user()) ? 'liked' : 'unliked' }}"
                                >
                                    <i class="{{ method_exists($post,'isLikedBy') && $post->isLikedBy(auth()->user()) ? 'fas fa-heart text-danger' : 'far fa-heart' }}"></i>
                                    <span class="ms-1" data-like-count>{{ $post->likes_rel_count ?? (method_exists($post,'likesCount') ? $post->likesCount() : ($post->likes_count ?? $post->likes->count())) }}</span>
                                </button>
                            @endauth
                            @guest
                                <span class="small text-muted">
                                    <i class="far fa-heart"></i>
                                    <span class="ms-1">{{ $post->likes_rel_count ?? ($post->likes_count ?? $post->likes->count()) }}</span>
                                </span>
                            @endguest
                        </div>
                    </div>
                </div>
            @empty
                <div class="parchment-panel soft-shadow text-center text-muted">Nenhum post encontrado.</div>
            @endforelse

            <div class="mt-3">{{ $posts->links() }}</div>
        </div>

    <div class="tab-pane fade {{ $currentTab==='resenhas' ? 'show active' : '' }}" id="resenhas" role="tabpanel" aria-labelledby="resenhas-tab">
            @forelse($resenhas as $resenha)
                <div class="parchment-panel soft-shadow mb-3">
                    <div class="d-flex justify-content-between small text-muted mb-2">
                        <span>por <a href="{{ route('profile.show',$resenha->user_id) }}" class="text-decoration-none">{{ $resenha->user->name }}</a></span>
                        <span>{{ $resenha->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="mb-1">
                        <a href="{{ route('livros.show',$resenha->livro_id) }}" class="text-decoration-none fw-semibold">{{ $resenha->livro->titulo }}</a>
                        @if($resenha->avaliacao)
                            <span class="badge bg-warning text-dark ms-2"><i class="fas fa-star me-1"></i>{{ $resenha->avaliacao }}/5</span>
                        @endif
                    </div>
                    <div class="text-muted small mb-2">{{ Str::limit(strip_tags($resenha->conteudo), 280) }}</div>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('resenhas.show',$resenha) }}" class="small text-decoration-none"><i class="fas fa-eye me-1"></i>Ler resenha</a>
                        <div class="d-flex align-items-center gap-3">
                            <span class="small text-muted"><i class="fas fa-comment me-1"></i>{{ $resenha->comments_count ?? $resenha->comments->count() }}</span>
                            @auth
                                <button
                                    class="btn btn-sm {{ method_exists($resenha,'isLikedBy') && $resenha->isLikedBy(auth()->user()) ? 'btn-outline-danger' : 'btn-outline-secondary' }}"
                                    data-like data-type="resenha" data-id="{{ $resenha->id }}"
                                    data-state="{{ method_exists($resenha,'isLikedBy') && $resenha->isLikedBy(auth()->user()) ? 'liked' : 'unliked' }}"
                                >
                                    <i class="{{ method_exists($resenha,'isLikedBy') && $resenha->isLikedBy(auth()->user()) ? 'fas fa-heart text-danger' : 'far fa-heart' }}"></i>
                                    <span class="ms-1" data-like-count>{{ $resenha->likes_rel_count ?? ($resenha->likes_count ?? (method_exists($resenha,'likesCount') ? $resenha->likesCount() : $resenha->likes->count())) }}</span>
                                </button>
                            @endauth
                            @guest
                                <span class="small text-muted">
                                    <i class="far fa-heart"></i>
                                    <span class="ms-1">{{ $resenha->likes_rel_count ?? ($resenha->likes_count ?? $resenha->likes->count()) }}</span>
                                </span>
                            @endguest
                        </div>
                    </div>
                </div>
            @empty
                <div class="parchment-panel soft-shadow text-center text-muted">Nenhuma resenha encontrada.</div>
            @endforelse

            <div class="mt-3">{{ $resenhas->links() }}</div>
        </div>

        <div class="tab-pane fade {{ $currentTab==='trending' ? 'show active' : '' }}" id="trending" role="tabpanel" aria-labelledby="trending-tab">
            @if(($trendingPosts ?? null) || ($trendingResenhas ?? null))
                <div class="parchment-panel soft-shadow mb-3">
                    <h2 class="h6 brand-font mb-2" style="color:var(--old-ink);"><i class="fas fa-bolt me-1" style="color:var(--old-accent);"></i>Posts em alta</h2>
                    @forelse(($trendingPosts ?? collect()) as $p)
                        <div class="border-bottom pb-2 mb-2 small">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="fw-semibold" style="color:var(--old-ink);">{{ Str::limit($p->content, 120) }}</div>
                                <span class="badge bg-info text-dark ms-2" title="Curtidas por hora (janela)">
                                    <i class="fas fa-tachometer-alt me-1"></i>{{ number_format($p->like_rate ?? 0, 2) }}/h
                                </span>
                            </div>
                            <div class="text-muted">por {{ $p->user->name }} • {{ $p->likes_window_count ?? 0 }} curtidas na janela</div>
                        </div>
                    @empty
                        <div class="text-muted small">Nada em alta.</div>
                    @endforelse
                </div>
                <div class="parchment-panel soft-shadow mb-3">
                    <h2 class="h6 brand-font mb-2" style="color:var(--old-ink);"><i class="fas fa-star-half-alt me-1" style="color:var(--old-accent);"></i>Resenhas em alta</h2>
                    @forelse(($trendingResenhas ?? collect()) as $r)
                        <div class="border-bottom pb-2 mb-2 small">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="fw-semibold" style="color:var(--old-ink);">{{ $r->livro->titulo ?? 'Livro' }}</div>
                                <span class="badge bg-info text-dark ms-2" title="Curtidas por hora (janela)">
                                    <i class="fas fa-tachometer-alt me-1"></i>{{ number_format($r->like_rate ?? 0, 2) }}/h
                                </span>
                            </div>
                            <div class="text-muted">{{ $r->user->name }} • {{ $r->likes_window_count ?? 0 }} curtidas na janela @if($r->avaliacao) • {{ $r->avaliacao }}/5 @endif</div>
                        </div>
                    @empty
                        <div class="text-muted small">Nenhuma resenha em alta.</div>
                    @endforelse
                </div>
            @else
                <div class="parchment-panel soft-shadow text-center text-muted">Sem dados em alta no momento.</div>
            @endif
        </div>
    </div>
@endsection
