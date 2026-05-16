<div
    id="commandModal"
    class="command-modal fixed inset-0 z-[100] flex items-start justify-center p-5 pt-[min(18vh,8rem)] opacity-0 invisible pointer-events-none transition-[opacity,visibility] duration-200 ease-out [&.is-open]:visible [&.is-open]:pointer-events-auto [&.is-open]:opacity-100 motion-reduce:transition-none"
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
        class="command-modal-card relative z-10 w-full max-w-lg scale-90 translate-y-5 rounded-2xl border border-emerald-500/20 bg-white/92 p-6 opacity-0 shadow-[0_24px_48px_-12px_rgb(5_150_105/0.2),inset_0_0_0_1px_rgb(255_255_255/0.5)] blur-[28px] transition-[opacity,transform,filter] duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] dark:border-emerald-400/25 dark:bg-[#141c18]/95 dark:shadow-[0_24px_48px_-12px_rgb(0_0_0/0.5),inset_0_0_0_1px_rgb(255_255_255/0.06)] motion-reduce:blur-none motion-reduce:transition-none"
    >
        <p
            id="commandModalTitle"
            class="mb-4 text-lg font-semibold tracking-tight text-[#1b1b18] dark:text-zinc-100"
        >
            Go to…
        </p>

        <input
            type="text"
            id="commandModalInput"
            class="block w-full select-text rounded-lg border border-emerald-500/25 bg-emerald-500/5 px-4 py-3 text-base text-[#1b1b18] outline-none transition-[border-color,box-shadow,background] duration-200 placeholder:text-gray-500 focus:border-emerald-500/55 focus:bg-white/95 focus:shadow-[0_0_0_3px_rgb(16_185_129/0.15)] dark:border-emerald-400/30 dark:bg-emerald-500/10 dark:text-zinc-100 dark:placeholder:text-zinc-400 dark:focus:border-emerald-400/50 dark:focus:bg-[#0f1714]/90 dark:focus:shadow-[0_0_0_3px_rgb(52_211_153/0.2)]"
            placeholder="Search modules…"
            autocomplete="off"
            spellcheck="false"
            autofocus
            aria-label="Search modules"
            aria-controls="commandModalResults"
            aria-activedescendant=""
            role="combobox"
            aria-expanded="true"
            aria-autocomplete="list"
        >

        <div
            id="commandModalResults"
            class="command-modal-results mt-3 max-h-64 overflow-y-auto rounded-lg border border-emerald-500/15 bg-emerald-500/[0.03] dark:border-emerald-400/20 dark:bg-emerald-500/[0.06]"
            role="listbox"
            aria-label="Module navigation"
            hidden
        ></div>

        <p id="commandModalEmpty" class="mt-3 hidden text-sm text-gray-500 dark:text-zinc-400">
            No matching destinations.
        </p>

        <p class="mt-3 text-sm text-gray-500 dark:text-zinc-400">
            <kbd class="inline-block rounded border border-emerald-500/25 bg-emerald-500/10 px-1.5 py-0.5 font-sans text-[0.8em]">↑</kbd>
            <kbd class="inline-block rounded border border-emerald-500/25 bg-emerald-500/10 px-1.5 py-0.5 font-sans text-[0.8em]">↓</kbd>
            to move,
            <kbd class="inline-block rounded border border-emerald-500/25 bg-emerald-500/10 px-1.5 py-0.5 font-sans text-[0.8em]">Enter</kbd>
            to open,
            <kbd class="inline-block rounded border border-emerald-500/25 bg-emerald-500/10 px-1.5 py-0.5 font-sans text-[0.8em]">Esc</kbd>
            to close ·
            <kbd class="inline-block rounded border border-emerald-500/25 bg-emerald-500/10 px-1.5 py-0.5 font-sans text-[0.8em]">⌘</kbd><kbd class="inline-block rounded border border-emerald-500/25 bg-emerald-500/10 px-1.5 py-0.5 font-sans text-[0.8em]">K</kbd>
            to open
        </p>
    </div>
</div>

<script>
    (() => {
        const commandItems = @json($items);

        const commandModal = document.getElementById('commandModal');
        const commandModalInput = document.getElementById('commandModalInput');
        const commandModalResults = document.getElementById('commandModalResults');
        const commandModalEmpty = document.getElementById('commandModalEmpty');
        const commandModalBackdrop = commandModal.querySelector('.command-modal-backdrop');
        const commandModalCard = commandModal.querySelector('.command-modal-card');

        let filteredItems = [...commandItems];
        let activeIndex = 0;
        let currentQuery = null;

        function focusCommandInput() {
            commandModalInput.focus({ preventScroll: true });
        }

        function normalizeQuery(value) {
            return value.trim().toLowerCase();
        }

        function itemMatchesQuery(item, query) {
            if (query === '') {
                return true;
            }

            const haystack = [
                item.label,
                item.group,
                ...(item.keywords ?? []),
            ].join(' ').toLowerCase();

            return haystack.includes(query);
        }

        function navigateTo(item) {
            if (!item?.url) {
                return;
            }

            window.location.assign(item.url);
        }

        function setActiveIndex(index) {
            if (filteredItems.length === 0) {
                activeIndex = -1;
                return;
            }

            activeIndex = (index + filteredItems.length) % filteredItems.length;
            renderResults();
        }

        function renderResults() {
            const query = normalizeQuery(commandModalInput.value);

            if (query !== currentQuery) {
                currentQuery = query;
                filteredItems = commandItems.filter((item) => itemMatchesQuery(item, query));
                activeIndex = filteredItems.length > 0 ? 0 : -1;
            }

            commandModalResults.innerHTML = '';
            commandModalResults.hidden = filteredItems.length === 0;
            commandModalEmpty.classList.toggle('hidden', filteredItems.length > 0);

            if (filteredItems.length === 0) {
                commandModalInput.setAttribute('aria-activedescendant', '');
                return;
            }

            let currentGroup = null;

            filteredItems.forEach((item, index) => {
                if (item.group !== currentGroup) {
                    currentGroup = item.group;

                    const groupLabel = document.createElement('div');
                    groupLabel.className = 'px-3 pt-2 pb-1 text-[0.7rem] font-semibold uppercase tracking-wider text-gray-500 dark:text-zinc-500';
                    groupLabel.textContent = currentGroup;
                    commandModalResults.appendChild(groupLabel);
                }

                const option = document.createElement('button');
                option.type = 'button';
                option.id = `command-item-${item.id}`;
                option.className = [
                    'command-modal-option flex w-full items-center justify-between gap-3 px-3 py-2.5 text-left text-sm transition-colors',
                    index === activeIndex
                        ? 'bg-emerald-500/15 text-[#1b1b18] dark:bg-emerald-500/20 dark:text-zinc-100'
                        : 'text-gray-700 hover:bg-emerald-500/10 dark:text-zinc-300 dark:hover:bg-emerald-500/10',
                ].join(' ');
                option.setAttribute('role', 'option');
                option.setAttribute('aria-selected', index === activeIndex ? 'true' : 'false');
                option.dataset.index = String(index);

                const label = document.createElement('span');
                label.className = 'font-medium';
                label.textContent = item.label;

                option.appendChild(label);

                option.addEventListener('mouseenter', () => {
                    activeIndex = index;
                    renderResults();
                });

                option.addEventListener('click', () => navigateTo(item));

                commandModalResults.appendChild(option);
            });

            const activeItem = filteredItems[activeIndex];
            commandModalInput.setAttribute(
                'aria-activedescendant',
                activeItem ? `command-item-${activeItem.id}` : '',
            );
        }

        function openCommandModal() {
            commandModal.hidden = false;
            commandModal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('overflow-hidden');
            commandModalInput.value = '';
            currentQuery = null;
            activeIndex = 0;
            renderResults();

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
            commandModalResults.hidden = true;
            commandModalEmpty.classList.add('hidden');
            commandModalInput.setAttribute('aria-activedescendant', '');

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

        commandModalInput.addEventListener('input', renderResults);

        commandModalInput.addEventListener('keydown', (event) => {
            if (event.key === 'ArrowDown') {
                event.preventDefault();
                setActiveIndex(activeIndex + 1);
                return;
            }

            if (event.key === 'ArrowUp') {
                event.preventDefault();
                setActiveIndex(activeIndex - 1);
                return;
            }

            if (event.key === 'Enter') {
                event.preventDefault();
                const item = filteredItems[activeIndex];
                if (item) {
                    navigateTo(item);
                }
            }
        });

        document.addEventListener('keydown', (event) => {
            if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
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
    })();
</script>
