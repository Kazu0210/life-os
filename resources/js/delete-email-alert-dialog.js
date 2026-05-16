const dialog = document.getElementById('delete-email-alert-dialog');
const description = dialog?.querySelector('#delete-email-alert-dialog-description');
const confirmButton = dialog?.querySelector('#delete-email-alert-dialog-confirm');
const cancelTriggers = dialog?.querySelectorAll('[data-delete-email-alert-cancel]') ?? [];

let pendingResolve = null;

function closeDialog(confirmed) {
    if (! dialog || pendingResolve === null) {
        return;
    }

    const resolve = pendingResolve;
    pendingResolve = null;
    let settled = false;

    const finish = () => {
        if (settled) {
            return;
        }

        settled = true;
        dialog.hidden = true;
        resolve(confirmed);
    };

    dialog.classList.remove('is-open');
    dialog.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('overflow-hidden');

    const onTransitionEnd = (event) => {
        if (event.target !== dialog || event.propertyName !== 'opacity') {
            return;
        }

        dialog.removeEventListener('transitionend', onTransitionEnd);
        finish();
    };

    dialog.addEventListener('transitionend', onTransitionEnd);
    setTimeout(finish, 250);
}

function openDialog(email) {
    return new Promise((resolve) => {
        if (! dialog || ! description || ! confirmButton) {
            resolve(false);

            return;
        }

        pendingResolve = resolve;
        description.textContent = `This will permanently delete "${email}". This action cannot be undone.`;
        dialog.hidden = false;
        dialog.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            dialog.classList.add('is-open');
            confirmButton.focus();
        });
    });
}

if (dialog) {
    confirmButton?.addEventListener('click', () => closeDialog(true));

    cancelTriggers.forEach((trigger) => {
        trigger.addEventListener('click', () => closeDialog(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && dialog.classList.contains('is-open')) {
            event.preventDefault();
            closeDialog(false);
        }
    });
}

export function confirmDeleteEmail(email) {
    return openDialog(email);
}
