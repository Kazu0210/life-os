<x-emails::layouts.master>
    <main class="relative flex min-h-dvh w-full flex-col px-5 py-8">
        <div class="welcome-glow pointer-events-none absolute inset-0 animate-bg-in motion-reduce:animate-none" aria-hidden="true"></div>

        <h1 class="relative text-center text-[clamp(2rem,6vw+0.5rem,3.5rem)] font-light tracking-[-0.045em] text-[#1b1b18] dark:text-zinc-100">
            <span class="inline-block opacity-0 animate-word-in delay-150 motion-reduce:animate-none motion-reduce:opacity-100">Emails</span>
        </h1>

        <div class="relative mt-10 w-full">
            <div class="mb-4 flex justify-end">
                <a
                    href="{{ route('emails.create') }}"
                    class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:ring-offset-2 dark:bg-emerald-500 dark:hover:bg-emerald-400 dark:focus:ring-offset-[#0a0f0c]"
                >
                    Add new email
                </a>
            </div>

            <table
                id="emails-table"
                class="w-full text-left text-sm"
                data-url="{{ route('emails.data') }}"
            >
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </main>
</x-emails::layouts.master>
