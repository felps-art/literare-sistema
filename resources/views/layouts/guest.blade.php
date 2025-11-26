<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Literare') }}</title>

        <!-- Fonts -->
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
                min-height: 100vh;
            }
            .brand-font { font-family: 'Cinzel', serif; letter-spacing: 1px; }
            /* Parchment-styled panel similar to dashboard */
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
            .soft-shadow { box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
            a { color: var(--old-accent); }
            a:hover { color: var(--old-accent-hover); }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="min-h-screen" style="display:flex; flex-direction:column; justify-content:center; align-items:center; padding: 1.25rem 0;">
            <div>
                <a href="/" class="text-decoration-none brand-font" style="color: var(--old-gold); font-size: 2rem;">
                    <i class="fas fa-book-open me-2"></i>Literare
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-4" style="width:100%; max-width: 560px;">
                <div class="parchment-panel soft-shadow">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <!-- Icons (Font Awesome) for the tiny book icon; optional -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </body>
    </html>
