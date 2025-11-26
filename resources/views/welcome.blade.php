<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo à Literare</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
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
        }
        body {
            background-color: var(--old-bg);
            font-family: 'Crimson Text', serif;
        }
        .brand-font {
            font-family: 'Cinzel', serif;
        }
        .parchment-panel {
            background: linear-gradient(145deg,#f8f1e1,#efe2c9,#f8f1e1);
            border: 1px solid var(--old-border);
            padding: 1.25rem 1.5rem;
            border-radius: 10px;
        }
        .soft-shadow {
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        }
        .card {
            background: #fffaf1;
            border: 1px solid var(--old-border);
        }
        .btn-primary {
            background: var(--old-accent);
            border-color: var(--old-accent);
        }
        .btn-primary:hover {
            background: var(--old-accent-hover);
            border-color: var(--old-accent-hover);
        }
        .btn-outline-primary {
            color: var(--old-accent);
            border-color: var(--old-accent);
        }
        .btn-outline-primary:hover {
            color: #fff;
            background: var(--old-accent);
            border-color: var(--old-accent);
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Bloco de Boas-Vindas --}}
        <div class="parchment-panel soft-shadow text-center p-5 my-5">
            <h1 class="display-4 brand-font" style="color: var(--old-ink);">Bem-vindo à Literare</h1>
            <p class="lead" style="color: var(--old-ink-muted);">Sua nova comunidade para compartilhar e descobrir leituras.</p>
            <hr class="my-4" style="border-color: var(--old-border);">
            <p>Junte-se a nós para organizar suas leituras, conectar-se com outros leitores e compartilhar suas opiniões.</p>
            <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">
                <i class="fas fa-sign-in-alt me-2"></i>Entrar
            </a>
            <a class="btn btn-outline-primary btn-lg" href="{{ route('register') }}" role="button">
                <i class="fas fa-user-plus me-2"></i>Cadastre-se
            </a>
        </div>

        {{-- Blocos de Apresentação --}}
        <div class="row text-center">
            {{-- Organize sua Leitura --}}
            <div class="col-md-4 mb-4">
                <div class="card h-100 soft-shadow">
                    <div class="card-body">
                        <div class="fa-3x mb-3" style="color: var(--old-accent);">
                            <i class="fas fa-book-reader"></i>
                        </div>
                        <h3 class="card-title h4 brand-font">Organize sua Leitura</h3>
                        <p class="card-text" style="color: var(--old-ink-muted);">
                            Mantenha um registro dos livros que você leu, está lendo ou quer ler. Nunca mais perca uma indicação.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Conecte-se --}}
            <div class="col-md-4 mb-4">
                <div class="card h-100 soft-shadow">
                    <div class="card-body">
                        <div class="fa-3x mb-3" style="color: var(--old-accent);">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="card-title h4 brand-font">Conecte-se</h3>
                        <p class="card-text" style="color: var(--old-ink-muted);">
                            Siga amigos e outros leitores para ver o que eles estão lendo e recomendando.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Compartilhe Opiniões --}}
            <div class="col-md-4 mb-4">
                <div class="card h-100 soft-shadow">
                    <div class="card-body">
                        <div class="fa-3x mb-3" style="color: var(--old-accent);">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3 class="card-title h4 brand-font">Compartilhe Opiniões</h3>
                        <p class="card-text" style="color: var(--old-ink-muted);">
                            Escreva resenhas, comente nas publicações e participe de discussões sobre seus livros favoritos.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

