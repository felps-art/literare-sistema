<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Literare</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts (Old Library Aesthetic) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --old-bg: #f4ecd8;
            --old-bg-accent: #e9dfc7;
            --old-border: #d2c2a8;
            --old-ink: #3b2f23;
            --old-ink-muted: #5c4b3a;
            --old-accent: #9c6b2f;
            --old-accent-hover: #b17a38;
            --old-danger: #7b2d2d;
            --old-nav: #2f2418;
            --old-nav-alt: #3d2f1f;
            --old-gold: #c6a054;
        }
        body {
            background: var(--old-bg);
            color: var(--old-ink);
            font-family: 'Crimson Text', serif;
            font-size: 1.05rem;
            line-height: 1.55;
            background-image:
                radial-gradient(circle at 25% 25%, rgba(255,255,255,0.25), transparent 70%),
                linear-gradient(180deg, rgba(255,255,255,0.4), rgba(255,255,255,0)),
                repeating-linear-gradient(0deg, rgba(0,0,0,0.02) 0 2px, transparent 2px 5px);
            background-blend-mode: multiply;
        }
        .brand-font {
            font-family: 'Cinzel', serif;
            letter-spacing: 1px;
            text-shadow: 0 1px 0 rgba(255,255,255,0.4), 0 2px 3px rgba(0,0,0,0.2);
        }
        .navbar-brand {
            font-size: 2.1rem;
            font-weight: 600;
            color: var(--old-gold) !important;
        }
        .navbar-dark.bg-primary {
            background: linear-gradient(135deg, var(--old-nav), var(--old-nav-alt)) !important;
            border-bottom: 3px solid var(--old-gold);
        }
        .navbar-dark .nav-link {
            font-family: 'Cinzel', serif;
            letter-spacing: .5px;
            color: #d9c9ad !important;
            transition: color .2s ease;
        }
        .navbar-dark .nav-link:hover, .navbar-dark .nav-link:focus, .navbar-dark .nav-link.active {
            color: var(--old-gold) !important;
        }
        .dropdown-menu {
            background: var(--old-bg-accent);
            border: 1px solid var(--old-border);
            box-shadow: 0 4px 14px rgba(0,0,0,0.18);
        }
        .dropdown-item:hover {
            background: var(--old-accent);
            color: #fff;
        }
        .card {
            background: #fffaf1;
            border: 1px solid var(--old-border);
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08), 0 6px 18px rgba(0,0,0,0.05);
            position: relative;
        }
        .card:before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: linear-gradient(145deg, rgba(255,255,255,0.4), rgba(255,255,255,0)),
                        linear-gradient(0deg, rgba(0,0,0,0.04), transparent 120%);
            mix-blend-mode: multiply;
            border-radius: inherit;
        }
        h1,h2,h3,h4,h5,h6 {
            font-family: 'Cinzel', serif;
            letter-spacing: .5px;
            color: var(--old-ink);
        }
        a { color: var(--old-accent); }
        a:hover { color: var(--old-accent-hover); }
        .btn-primary, .btn-outline-primary:hover {
            background: var(--old-accent);
            border-color: var(--old-accent);
        }
        .btn-primary:hover { background: var(--old-accent-hover); }
        .btn-outline-primary {
            color: var(--old-accent);
            border-color: var(--old-accent);
        }
        .badge.bg-danger { background: var(--old-danger) !important; }
        footer.bg-dark {
            background: var(--old-nav) !important;
            border-top: 3px solid var(--old-gold);
        }
        footer h5 { color: var(--old-gold); }
        .alert-info { background: #e3d7bf; border-color: var(--old-border); color: var(--old-ink-muted); }
        .table, table { --bs-table-striped-bg: #f3ead7; }
        /* Scrollbar (Webkit) */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: var(--old-bg-accent); }
        ::-webkit-scrollbar-thumb { background: var(--old-accent); border-radius: 6px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--old-accent-hover); }
        /* Utility parchment panel */
        .parchment-panel {
            background: linear-gradient(145deg,#f8f1e1,#efe2c9,#f8f1e1);
            border: 1px solid var(--old-border);
            padding: 1.25rem 1.5rem;
            border-radius: 10px;
            position: relative;
        }
        .parchment-panel:after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: repeating-linear-gradient(0deg, rgba(0,0,0,0.015) 0 2px, transparent 2px 5px);
            border-radius: inherit;
        }
        /* Shadows for depth */
        .soft-shadow { box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
    </style>
    @stack('head')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand brand-font" href="{{ auth()->check() && auth()->user()->is_admin ? route('dashboard') : route('feed.index') }}">
                <i class="fas fa-book-open me-2"></i>Literare
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('feed.index') }}">
                                <i class="fas fa-home me-1"></i>Início
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('explorar') }}">
                                <i class="fas fa-compass me-1"></i>Explorar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('posts.index') }}">
                                <i class="fas fa-comments me-1"></i>Posts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('resenhas.index') }}">
                                <i class="fas fa-star me-1"></i>Resenhas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('estante.index') }}">
                                <i class="fas fa-books me-1"></i>Estante
                            </a>
                        </li>
                        <!-- Links de Livros e Usuários removidos da navbar superior -->
                    @endauth
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                @if(auth()->user()->foto_perfil)
                                    <img src="{{ asset('storage/' . auth()->user()->foto_perfil) }}" 
                                         class="rounded-circle me-2" width="32" height="32">
                                @else
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" 
                                         style="width: 32px; height: 32px; color: #6c757d;">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <span>{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.show', auth()->id()) }}">
                                        <i class="fas fa-user me-2"></i>Meu Perfil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('resenhas.create') }}">
                                        <i class="fas fa-plus me-2"></i>Nova Resenha
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('posts.create') }}">
                                        <i class="fas fa-edit me-2"></i>Novo Post
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger" 
                                                onclick="return confirm('Deseja realmente sair?')">
                                            <i class="fas fa-sign-out-alt me-2"></i>Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link btn btn-light text-primary px-3" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Entrar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container my-4">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="brand-font">Literare</h5>
                    <p class="mb-0">Sua comunidade literária online</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        <small>&copy; {{ date('Y') }} Literare. Todos os direitos reservados.</small>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <script>
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('[data-like]');
        if(!btn) return;
        if(!document.querySelector('meta[name="csrf-token"]')) return;
        e.preventDefault();
        if(btn.dataset.loading === '1') return;
        const type = btn.dataset.type; // post | resenha
        const id = btn.dataset.id;
        const liked = btn.dataset.state === 'liked';
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let url = '';
        if(type === 'post') url = '/posts/' + id + '/like';
        else if(type === 'resenha') url = '/resenhas/' + id + '/like';
        else return;
        const method = liked ? 'DELETE' : 'POST';
        const icon = btn.querySelector('i');
        const countEl = btn.querySelector('[data-like-count]');
        const originalIcon = icon ? icon.className : '';
        btn.dataset.loading = '1';
        if(icon) icon.className = 'fas fa-spinner fa-spin';
        try {
            const resp = await fetch(url, {
                method,
                headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            if(!resp.ok) throw new Error('Erro');
            const data = await resp.json();
            btn.dataset.state = data.liked ? 'liked' : 'unliked';
            if(icon) icon.className = data.liked ? 'fas fa-heart text-danger' : 'far fa-heart';
            if(countEl) countEl.textContent = data.likes_count;
        } catch(err){
            if(icon) icon.className = originalIcon;
            console.error(err);
        } finally {
            btn.dataset.loading = '0';
        }
    });
    </script>
</body>
</html>