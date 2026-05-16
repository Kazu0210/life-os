<div
    id="delete-email-alert-dialog"
    class="delete-email-alert-dialog fixed inset-0 z-50 opacity-0 invisible pointer-events-none transition-[opacity,visibility] duration-200 ease-out [&.is-open]:visible [&.is-open]:pointer-events-auto [&.is-open]:opacity-100 motion-reduce:transition-none"
    role="alertdialog"
    aria-modal="true"
    aria-labelledby="delete-email-alert-dialog-title"
    aria-describedby="delete-email-alert-dialog-description"
    aria-hidden="true"
    hidden
>
    <div
        class="delete-email-alert-dialog-overlay fixed inset-0 bg-black/80"
        data-delete-email-alert-cancel
    ></div>

    <div
        class="delete-email-alert-dialog-content fixed left-1/2 top-1/2 z-50 grid w-full max-w-lg -translate-x-1/2 -translate-y-1/2 gap-4 border border-zinc-200 bg-white p-6 shadow-lg duration-200 sm:rounded-lg dark:border-zinc-800 dark:bg-zinc-950"
    >
        <div class="flex flex-col gap-2 text-center sm:text-left">
            <h2
                id="delete-email-alert-dialog-title"
                class="text-lg font-semibold leading-none tracking-tight text-zinc-950 dark:text-zinc-50"
            >
                Delete email?
            </h2>
            <p
                id="delete-email-alert-dialog-description"
                class="text-sm text-zinc-500 dark:text-zinc-400"
            >
                This action cannot be undone. This will permanently delete the email address from your list.
            </p>
        </div>

        <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end sm:gap-2">
            <button
                type="button"
                data-delete-email-alert-cancel
                class="inline-flex h-10 items-center justify-center rounded-md border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-950 transition-colors hover:bg-zinc-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 focus-visible:ring-offset-2 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50 dark:hover:bg-zinc-800 dark:focus-visible:ring-zinc-300 dark:focus-visible:ring-offset-zinc-950"
            >
                Cancel
            </button>
            <button
                type="button"
                id="delete-email-alert-dialog-confirm"
                class="inline-flex h-10 items-center justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-600 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-zinc-950"
            >
                Delete
            </button>
        </div>
    </div>
</div>
