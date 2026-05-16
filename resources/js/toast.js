const TOAST_DURATION_MS = 4000;

const variantClasses = {
    default:
        'border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-950',
    success:
        'border-emerald-500/30 bg-white dark:border-emerald-400/30 dark:bg-zinc-950',
    destructive:
        'border-red-500/30 bg-white dark:border-red-400/30 dark:bg-zinc-950',
};

export function showToast({ title, description, variant = 'default' }) {
    const container = document.getElementById('toast-container');

    if (! container) {
        return;
    }

    const toast = document.createElement('div');
    toast.className = [
        'toast pointer-events-auto relative flex w-full items-start gap-3 overflow-hidden rounded-md border p-4 shadow-lg transition-all duration-300 ease-out',
        variantClasses[variant] ?? variantClasses.default,
        'translate-y-2 opacity-0',
    ].join(' ');
    toast.setAttribute('role', 'status');

    const content = document.createElement('div');
    content.className = 'grid flex-1 gap-1';

    const titleEl = document.createElement('p');
    titleEl.className = 'text-sm font-semibold text-zinc-950 dark:text-zinc-50';
    titleEl.textContent = title;
    content.appendChild(titleEl);

    if (description) {
        const descriptionEl = document.createElement('p');
        descriptionEl.className = 'text-sm text-zinc-500 dark:text-zinc-400';
        descriptionEl.textContent = description;
        content.appendChild(descriptionEl);
    }

    toast.appendChild(content);
    container.appendChild(toast);

    requestAnimationFrame(() => {
        toast.classList.remove('translate-y-2', 'opacity-0');
    });

    const dismiss = () => {
        toast.classList.add('translate-y-2', 'opacity-0');

        setTimeout(() => {
            toast.remove();
        }, 300);
    };

    const timeoutId = setTimeout(dismiss, TOAST_DURATION_MS);

    toast.addEventListener('click', () => {
        clearTimeout(timeoutId);
        dismiss();
    });
}
