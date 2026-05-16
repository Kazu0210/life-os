<style>
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
        margin-bottom: 1rem;
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

    .command-modal__input {
        display: block;
        width: 100%;
        padding: 0.75rem 1rem;
        font-family: inherit;
        font-size: 1rem;
        line-height: 1.5;
        color: #1b1b18;
        background: rgba(16, 185, 129, 0.06);
        border: 1px solid rgba(16, 185, 129, 0.25);
        border-radius: 0.625rem;
        outline: none;
        -webkit-user-select: text;
        user-select: text;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }

    .command-modal__input::placeholder {
        color: #6b7280;
    }

    .command-modal__input:focus {
        background: rgba(255, 255, 255, 0.95);
        border-color: rgba(16, 185, 129, 0.55);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
    }

    @media (prefers-color-scheme: dark) {
        .command-modal__input {
            color: #f4f4f5;
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(52, 211, 153, 0.3);
        }

        .command-modal__input::placeholder {
            color: #a1a1aa;
        }

        .command-modal__input:focus {
            background: rgba(15, 23, 20, 0.9);
            border-color: rgba(52, 211, 153, 0.5);
            box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.2);
        }
    }

    .command-modal__hint {
        margin-top: 0.75rem;
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
        <input
            type="text"
            class="command-modal__input"
            id="commandModalInput"
            placeholder="Search or type a command..."
            autocomplete="off"
            spellcheck="false"
            aria-label="Search or type a command"
        >
        <p class="command-modal__hint">Press <kbd>Ctrl</kbd>+<kbd>K</kbd> or <kbd>Esc</kbd> to close</p>
    </div>
</div>

<script>
    const commandModal = document.getElementById('commandModal');
    const commandModalInput = document.getElementById('commandModalInput');

    function openCommandModal() {
        commandModal.hidden = false;
        commandModal.setAttribute('aria-hidden', 'false');
        requestAnimationFrame(() => {
            commandModal.classList.add('is-open');
            commandModalInput.focus();
            commandModalInput.select();
        });
        document.body.classList.add('modal-open');
    }

    function closeCommandModal() {
        commandModal.classList.remove('is-open');
        commandModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
        commandModalInput.blur();
        commandModalInput.value = '';

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
