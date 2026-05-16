<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @fonts

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            *,
            *::before,
            *::after {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                min-height: 100vh;
                min-height: 100dvh;
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                background-color: #f6faf8;
                color: #1b1b18;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                -webkit-user-select: none;
                user-select: none;
            }

            @media (prefers-color-scheme: dark) {
                body {
                    background-color: #0a0f0c;
                    color: #ededec;
                }
            }

            .welcome {
                position: relative;
                display: flex;
                min-height: 100vh;
                min-height: 100dvh;
                width: 100%;
                align-items: center;
                justify-content: center;
                padding: 2rem 1.25rem;
                overflow: hidden;
            }

            .welcome::before {
                content: '';
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(ellipse 80% 50% at 50% -20%, rgba(16, 185, 129, 0.14), transparent),
                    radial-gradient(ellipse 60% 40% at 100% 100%, rgba(34, 197, 94, 0.1), transparent),
                    radial-gradient(ellipse 50% 30% at 0% 80%, rgba(5, 150, 105, 0.08), transparent);
                pointer-events: none;
                animation: bg-in 1.2s ease-out both;
            }

            @media (prefers-color-scheme: dark) {
                .welcome::before {
                    background:
                        radial-gradient(ellipse 80% 50% at 50% -20%, rgba(52, 211, 153, 0.2), transparent),
                        radial-gradient(ellipse 60% 40% at 100% 100%, rgba(74, 222, 128, 0.14), transparent),
                        radial-gradient(ellipse 50% 30% at 0% 80%, rgba(16, 185, 129, 0.12), transparent);
                }
            }

            .welcome__label {
                position: relative;
                display: flex;
                flex-wrap: wrap;
                align-items: baseline;
                justify-content: center;
                gap: 0.12em;
                text-align: center;
                font-size: clamp(2.5rem, 8vw + 0.5rem, 5.5rem);
                font-weight: 300;
                letter-spacing: -0.045em;
                line-height: 1;
                max-width: 100%;
            }

            .welcome__label-life {
                display: inline-block;
                font-weight: 300;
                color: #1b1b18;
                opacity: 0;
                animation: word-in 0.85s cubic-bezier(0.22, 1, 0.36, 1) 0.15s both;
            }

            .welcome__label-os {
                display: inline-block;
                font-weight: 600;
                background: linear-gradient(135deg, #047857 0%, #059669 50%, #10b981 100%);
                background-size: 200% 200%;
                -webkit-background-clip: text;
                background-clip: text;
                -webkit-text-fill-color: transparent;
                opacity: 0;
                animation:
                    word-in 0.85s cubic-bezier(0.22, 1, 0.36, 1) 0.4s both,
                    gradient-shift 4s ease-in-out 1.1s infinite;
            }

            @media (prefers-color-scheme: dark) {
                .welcome__label-life {
                    color: #f4f4f5;
                }

                .welcome__label-os {
                    background: linear-gradient(135deg, #6ee7b7 0%, #34d399 50%, #10b981 100%);
                    background-size: 200% 200%;
                    -webkit-background-clip: text;
                    background-clip: text;
                    -webkit-text-fill-color: transparent;
                }
            }

            @keyframes bg-in {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            @keyframes word-in {
                from {
                    opacity: 0;
                    transform: translateY(28px) scale(0.92);
                    filter: blur(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                    filter: blur(0);
                }
            }

            @keyframes gradient-shift {
                0%,
                100% {
                    background-position: 0% 50%;
                }
                50% {
                    background-position: 100% 50%;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .welcome::before,
                .welcome__label-life,
                .welcome__label-os {
                    animation: none;
                    opacity: 1;
                    filter: none;
                    transform: none;
                }
            }
        </style>
    </head>
    <body>
        <main class="welcome">
            <h1 class="welcome__label">
                <span class="welcome__label-life">Life</span>
                <span class="welcome__label-os">OS</span>
            </h1>
        </main>
    </body>
</html>
