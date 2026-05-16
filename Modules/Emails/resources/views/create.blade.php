<x-emails::layouts.master>
    <main class="relative flex min-h-dvh w-full flex-col px-5 py-8">
        <div class="welcome-glow pointer-events-none absolute inset-0 animate-bg-in motion-reduce:animate-none" aria-hidden="true"></div>

        <div class="relative">
            <a
                href="{{ route('emails.index') }}"
                class="text-sm text-gray-500 transition-colors hover:text-emerald-600 dark:text-zinc-400 dark:hover:text-emerald-400"
            >
                ← Back to emails
            </a>

            <h1 class="mt-4 text-2xl font-semibold tracking-tight text-[#1b1b18] dark:text-zinc-100">
                Add new email
            </h1>

            <form action="{{ route('emails.store') }}" method="POST" class="relative mt-8 space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-[#1b1b18] dark:text-zinc-100">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        class="block w-full rounded-lg border border-emerald-500/25 bg-white/90 px-4 py-2.5 text-sm text-[#1b1b18] outline-none transition-[border-color,box-shadow] focus:border-emerald-500/55 focus:shadow-[0_0_0_3px_rgb(16_185_129/0.15)] dark:border-emerald-400/30 dark:bg-[#141c18]/95 dark:text-zinc-100"
                        required
                    >
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button
                        type="submit"
                        class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:ring-offset-2 dark:bg-emerald-500 dark:hover:bg-emerald-400 dark:focus:ring-offset-[#0a0f0c]"
                    >
                        Save email
                    </button>
                    <a
                        href="{{ route('emails.index') }}"
                        class="text-sm text-gray-500 transition-colors hover:text-[#1b1b18] dark:text-zinc-400 dark:hover:text-zinc-100"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-emails::layouts.master>
