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

            .command-modal {
                position: fixed;
                inset: 0;
                z-index: 100;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1.25rem;
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
                transition: opacity 0.22s ease, visibility 0.22s ease;
            }

            .command-modal.is-open {
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
            }

            .command-modal__backdrop {
                position: absolute;
                inset: 0;
                background: rgba(15, 23, 20, 0.2);
                backdrop-filter: blur(0);
                -webkit-backdrop-filter: blur(0);
            }

            .command-modal.is-open .command-modal__backdrop {
                animation: backdrop-blur-in 0.28s ease forwards;
            }

            @media (prefers-color-scheme: dark) {
                @keyframes backdrop-blur-in {
                    from {
                        background: rgba(0, 0, 0, 0.25);
                        backdrop-filter: blur(0);
                        -webkit-backdrop-filter: blur(0);
                    }
                    to {
                        background: rgba(0, 0, 0, 0.65);
                        backdrop-filter: blur(16px);
                        -webkit-backdrop-filter: blur(16px);
                    }
                }
            }

            .command-modal__card {
                position: relative;
                z-index: 1;
                width: min(100%, 28rem);
                padding: 1.5rem;
                border-radius: 1rem;
                border: 1px solid rgba(16, 185, 129, 0.2);
                background: rgba(255, 255, 255, 0.92);
                box-shadow:
                    0 24px 48px -12px rgba(5, 150, 105, 0.2),
                    0 0 0 1px rgba(255, 255, 255, 0.5) inset;
                opacity: 0;
                transform: scale(0.9) translateY(20px);
                filter: blur(28px);
                transition:
                    opacity 0.25s cubic-bezier(0.22, 1, 0.36, 1),
                    transform 0.25s cubic-bezier(0.22, 1, 0.36, 1),
                    filter 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            }

            .command-modal.is-open .command-modal__card {
                animation: card-blur-in 0.42s cubic-bezier(0.22, 1, 0.36, 1) 0.05s both;
            }

            @keyframes backdrop-blur-in {
                from {
                    background: rgba(15, 23, 20, 0.15);
                    backdrop-filter: blur(0);
                    -webkit-backdrop-filter: blur(0);
                }
                to {
                    background: rgba(15, 23, 20, 0.5);
                    backdrop-filter: blur(16px);
                    -webkit-backdrop-filter: blur(16px);
                }
            }

            @keyframes card-blur-in {
                0% {
                    opacity: 0;
                    transform: scale(0.88) translateY(24px);
                    filter: blur(32px);
                }
                35% {
                    opacity: 0.6;
                    filter: blur(18px);
                }
                65% {
                    opacity: 0.9;
                    filter: blur(6px);
                }
                100% {
                    opacity: 1;
                    transform: scale(1) translateY(0);
                    filter: blur(0);
                }
            }

            @media (prefers-color-scheme: dark) {
                .command-modal__card {
                    background: rgba(20, 28, 24, 0.95);
                    border-color: rgba(52, 211, 153, 0.25);
                    box-shadow:
                        0 24px 48px -12px rgba(0, 0, 0, 0.5),
                        0 0 0 1px rgba(255, 255, 255, 0.06) inset;
                }
            }

            .command-modal__title {
                font-size: 1.125rem;
                font-weight: 600;
                letter-spacing: -0.02em;
                color: #1b1b18;
            }

            @media (prefers-color-scheme: dark) {
                .command-modal__title {
                    color: #f4f4f5;
                }
            }

            .command-modal__hint {
                margin-top: 0.5rem;
                font-size: 0.875rem;
                color: #6b7280;
            }

            .command-modal__hint kbd {
                display: inline-block;
                padding: 0.1em 0.4em;
                font-family: inherit;
                font-size: 0.8em;
                border-radius: 0.25rem;
                border: 1px solid rgba(16, 185, 129, 0.25);
                background: rgba(16, 185, 129, 0.08);
            }

            @media (prefers-color-scheme: dark) {
                .command-modal__hint {
                    color: #a1a1aa;
                }
            }

            body.modal-open {
                overflow: hidden;
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

                .command-modal,
                .command-modal__backdrop,
                .command-modal__card {
                    transition: none;
                    animation: none;
                }

                .command-modal.is-open .command-modal__backdrop {
                    backdrop-filter: blur(16px);
                    -webkit-backdrop-filter: blur(16px);
                    background: rgba(15, 23, 20, 0.5);
                }

                .command-modal__card,
                .command-modal.is-open .command-modal__card {
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

        <div
            class="command-modal"
            id="commandModal"
            role="dialog"
            aria-modal="true"
            aria-labelledby="commandModalTitle"
            aria-hidden="true"
            hidden
        >
            <div class="command-modal__backdrop" data-command-modal-close></div>
            <div class="command-modal__card">
                <p class="command-modal__title" id="commandModalTitle">Command palette</p>
                <p class="command-modal__hint">Press <kbd>Ctrl</kbd>+<kbd>K</kbd> or <kbd>Esc</kbd> to close</p>
            </div>
        </div>

        <script>
            const commandModal = document.getElementById('commandModal');

            function openCommandModal() {
                commandModal.hidden = false;
                commandModal.setAttribute('aria-hidden', 'false');
                requestAnimationFrame(() => {
                    commandModal.classList.add('is-open');
                });
                document.body.classList.add('modal-open');
            }

            function closeCommandModal() {
                commandModal.classList.remove('is-open');
                commandModal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('modal-open');

                const onTransitionEnd = (event) => {
                    if (event.target !== commandModal || event.propertyName !== 'opacity') {
                        return;
                    }
                    commandModal.hidden = true;
                    commandModal.removeEventListener('transitionend', onTransitionEnd);
                };

                commandModal.addEventListener('transitionend', onTransitionEnd);
            }

            function toggleCommandModal() {
                if (commandModal.classList.contains('is-open')) {
                    closeCommandModal();
                } else {
                    openCommandModal();
                }
            }

            document.addEventListener('keydown', (event) => {
                if (event.ctrlKey && event.key.toLowerCase() === 'k') {
                    event.preventDefault();
                    toggleCommandModal();
                    return;
                }

                if (event.key === 'Escape' && commandModal.classList.contains('is-open')) {
                    event.preventDefault();
                    closeCommandModal();
                }
            });

            commandModal.querySelector('[data-command-modal-close]').addEventListener('click', closeCommandModal);
        </script>
    </body>
</html>
