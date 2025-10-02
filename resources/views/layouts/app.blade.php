<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Literare</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        .brand-font { 
            font-family: 'Playfair Display', serif; 
            letter-spacing: .5px; 
        }
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-size: 2rem;
            font-weight: 700;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand brand-font" href="{{ route('dashboard') }}">
                <i class="fas fa-book-open me-2"></i>Literare
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
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
                            <a class="nav-link" href="{{ route('livros.index') }}">
                                <i class="fas fa-book me-1"></i>Livros
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">
                                <i class="fas fa-users me-1"></i>Usuários
                            </a>
                        </li>
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
</body>
</html>