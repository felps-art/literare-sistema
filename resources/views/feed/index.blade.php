@extends('layouts.app')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="parchment-panel soft-shadow mb-3 d-flex justify-content-between align-items-center">
            <h1 class="h5 brand-font m-0" style="color:var(--old-ink);"><i class="fas fa-rss me-2" style="color:var(--old-accent);"></i>Feed</h1>
        </div>

        @forelse($activities as $activity)
            @php
                $u = $activity->user;
                $type = $activity->type;
                $subject = $activity->subject;
            @endphp
            <div class="parchment-panel soft-shadow mb-3 p-3">
                <div class="d-flex gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px;background:#efe2c9;font-weight:600;">
                        {{ strtoupper(substr($u->name,0,1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="small mb-1">
                            <strong>{{ $u->name }}</strong>
                            @switch($type)
                                @case('post_created')
                                    publicou um novo post
                                    @break
                                @case('resenha_created')
                                    escreveu uma resenha
                                    @break
                                @case('status_update')
                                    atualizou status de leitura
                                    @break
                                @default
                                    fez uma atividade
                            @endswitch
                            <span class="text-muted">· {{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="activity-body small">
                            @if($type === 'post_created' && $subject)
                                <a href="#" class="text-decoration-none" style="color:var(--old-ink);">{{ Str::limit($subject->content, 160) }}</a>
                            @elseif($type === 'resenha_created' && $subject)
                                <div>
                                    <span class="badge bg-warning text-dark me-1"><i class="fas fa-star"></i> {{ $subject->avaliacao ?? '-' }}/5</span>
                                    sobre o livro <strong>{{ $subject->livro->titulo ?? 'Livro' }}</strong>
                                </div>
                                <div class="text-muted mt-1" style="font-family:'Crimson Text', serif;">{!! nl2br(e(Str::limit($subject->conteudo, 220))) !!}</div>
                            @elseif($type === 'status_update')
                                @php $meta = $activity->meta ?? []; @endphp
                                <div>Status: <strong>{{ $meta['status'] ?? '' }}</strong> @if(isset($meta['nota'])) • Nota: {{ $meta['nota'] }} @endif</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="parchment-panel soft-shadow p-4 text-center text-muted">Ainda sem atividades. Siga usuários ou crie conteúdo.</div>
        @endforelse

        @if($nextCursor)
            <div class="text-center mb-5">
                <a href="?cursor={{ $nextCursor }}" class="btn btn-sm btn-outline-secondary">Carregar mais</a>
            </div>
        @endif
    </div>
    <div class="col-lg-4">
        <div class="parchment-panel soft-shadow mb-4">
            <h2 class="h6 brand-font mb-3" style="color:var(--old-ink);"><i class="fas fa-fire me-2" style="color:var(--old-accent);"></i>Trending Posts</h2>
            @forelse($trendingPosts as $p)
                <div class="mb-2 small">
                    <div class="fw-semibold" style="color:var(--old-ink);">{{ Str::limit($p->content, 80) }}</div>
                    <div class="text-muted">por {{ $p->user->name }} • {{ $p->likes_count }} curtidas</div>
                </div>
            @empty
                <div class="text-muted small">Nada em alta ainda.</div>
            @endforelse
        </div>
        <div class="parchment-panel soft-shadow mb-4">
            <h2 class="h6 brand-font mb-3" style="color:var(--old-ink);"><i class="fas fa-star-half-alt me-2" style="color:var(--old-accent);"></i>Trending Resenhas</h2>
            @forelse($trendingResenhas as $r)
                <div class="mb-2 small">
                    <div class="fw-semibold" style="color:var(--old-ink);">{{ $r->livro->titulo ?? 'Livro' }}</div>
                    <div class="text-muted">{{ $r->user->name }} • {{ $r->likes_count }} likes • {{ $r->avaliacao ?? '-' }}/5</div>
                </div>
            @empty
                <div class="text-muted small">Nenhuma resenha em destaque.</div>
            @endforelse
        </div>
        @auth
        <div class="parchment-panel soft-shadow mb-4">
            <h2 class="h6 brand-font mb-3" style="color:var(--old-ink);"><i class="fas fa-user-plus me-2" style="color:var(--old-accent);"></i>Sugestões</h2>
            @forelse($suggestedUsers as $su)
                <div class="d-flex justify-content-between align-items-center mb-2 small">
                    <div>
                        <strong>{{ $su->name }}</strong><br>
                        <span class="text-muted">{{ $su->followers_count }} seguidores</span>
                    </div>
                    <form method="POST" action="#" onsubmit="event.preventDefault(); /* implementar follow */" class="ms-2">
                        <button class="btn btn-sm btn-outline-primary" disabled>Seguir</button>
                    </form>
                </div>
            @empty
                <div class="text-muted small">Sem sugestões agora.</div>
            @endforelse
        </div>
        @endauth
    </div>
</div>
@endsection
