<x-emails::layouts.master>
    <main class="relative flex min-h-dvh w-full flex-col px-5 py-8">
        <div class="welcome-glow pointer-events-none absolute inset-0 animate-bg-in motion-reduce:animate-none" aria-hidden="true"></div>

        <h1 class="relative text-center text-[clamp(2rem,6vw+0.5rem,3.5rem)] font-light tracking-[-0.045em] text-[#1b1b18] dark:text-zinc-100">
            <span class="inline-block opacity-0 animate-word-in delay-150 motion-reduce:animate-none motion-reduce:opacity-100">Emails</span>
        </h1>

        <div class="relative mt-10 w-full">
            <table id="emails-table" class="w-full text-left text-sm">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>From</th>
                        <th>Received</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </main>
</x-emails::layouts.master>
