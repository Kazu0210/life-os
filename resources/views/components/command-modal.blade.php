<div
    id="commandModal"
    class="command-modal fixed inset-0 z-[100] flex items-center justify-center p-5 opacity-0 invisible pointer-events-none transition-[opacity,visibility] duration-200 ease-out [&.is-open]:visible [&.is-open]:pointer-events-auto [&.is-open]:opacity-100 motion-reduce:transition-none"
    role="dialog"
    aria-modal="true"
    aria-labelledby="commandModalTitle"
    aria-hidden="true"
    hidden
>
    <div
        class="command-modal-backdrop absolute inset-0 bg-emerald-950/15 backdrop-blur-none motion-reduce:backdrop-blur-xl"
        data-command-modal-close
    ></div>

    <div
        class="command-modal-card relative z-10 w-full max-w-md scale-90 translate-y-5 rounded-2xl border border-emerald-500/20 bg-white/92 p-6 opacity-0 shadow-[0_24px_48px_-12px_rgb(5_150_105/0.2),inset_0_0_0_1px_rgb(255_255_255/0.5)] blur-[28px] transition-[opacity,transform,filter] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] dark:border-emerald-400/25 dark:bg-[#141c18]/95 dark:shadow-[0_24px_48px_-12px_rgb(0_0_0/0.5),inset_0_0_0_1px_rgb(255_255_255/0.06)] motion-reduce:blur-none motion-reduce:transition-none"
    >
        <p
            id="commandModalTitle"
            class="mb-4 text-lg font-semibold tracking-tight text-[#1b1b18] dark:text-zinc-100"
        >
            Command palette
        </p>

        <input
            type="text"
            id="commandModalInput"
            class="block w-full select-text rounded-lg border border-emerald-500/25 bg-emerald-500/5 px-4 py-3 text-base text-[#1b1b18] outline-none transition-[border-color,box-shadow,background] duration-200 placeholder:text-gray-500 focus:border-emerald-500/55 focus:bg-white/95 focus:shadow-[0_0_0_3px_rgb(16_185_129/0.15)] dark:border-emerald-400/30 dark:bg-emerald-500/10 dark:text-zinc-100 dark:placeholder:text-zinc-400 dark:focus:border-emerald-400/50 dark:focus:bg-[#0f1714]/90 dark:focus:shadow-[0_0_0_3px_rgb(52_211_153/0.2)]"
            placeholder="Search or type a command..."
            autocomplete="off"
            spellcheck="false"
            autofocus
            aria-label="Search or type a command"
        >

        <p class="mt-3 text-sm text-gray-500 dark:text-zinc-400">
            Press
            <kbd class="inline-block rounded border border-emerald-500/25 bg-emerald-500/10 px-1.5 py-0.5 font-sans text-[0.8em]">Ctrl</kbd>+<kbd class="inline-block rounded border border-emerald-500/25 bg-emerald-500/10 px-1.5 py-0.5 font-sans text-[0.8em]">K</kbd>
            or
            <kbd class="inline-block rounded border border-emerald-500/25 bg-emerald-500/10 px-1.5 py-0.5 font-sans text-[0.8em]">Esc</kbd>
            to close
        </p>
    </div>
</div>

<script>
    const commandModal = document.getElementById('commandModal');
    const commandModalInput = document.getElementById('commandModalInput');
    const commandModalBackdrop = commandModal.querySelector('.command-modal-backdrop');
    const commandModalCard = commandModal.querySelector('.command-modal-card');

    function focusCommandInput() {
        commandModalInput.focus({ preventScroll: true });
    }

    function openCommandModal() {
        commandModal.hidden = false;
        commandModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            commandModal.classList.add('is-open');
            focusCommandInput();
            requestAnimationFrame(focusCommandInput);
        });

        setTimeout(focusCommandInput, 50);

        const onCardReady = (event) => {
            if (event.target !== commandModalCard || event.animationName !== 'card-blur-in') {
                return;
            }
            focusCommandInput();
            commandModalCard.removeEventListener('animationend', onCardReady);
        };

        commandModalCard.addEventListener('animationend', onCardReady);
    }

    function closeCommandModal() {
        commandModal.classList.remove('is-open');
        commandModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
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

    commandModalBackdrop.addEventListener('click', closeCommandModal);
</script>
