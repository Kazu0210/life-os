<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-dvh bg-[#f6faf8] font-sans text-[#1b1b18] antialiased select-none dark:bg-[#0a0f0c] dark:text-[#ededec]">
        <main class="relative flex min-h-dvh w-full items-center justify-center overflow-hidden px-5 py-8">
            <div class="welcome-glow pointer-events-none absolute inset-0 animate-bg-in motion-reduce:animate-none" aria-hidden="true"></div>

            <h1 class="relative flex max-w-full flex-wrap items-baseline justify-center gap-[0.12em] text-center text-[clamp(2.5rem,8vw+0.5rem,5.5rem)] leading-none font-light tracking-[-0.045em]">
                <span class="inline-block font-light text-[#1b1b18] opacity-0 animate-word-in delay-150 motion-reduce:animate-none motion-reduce:opacity-100 dark:text-zinc-100">Life</span>
                <span class="inline-block bg-[length:200%_200%] bg-gradient-to-br from-emerald-800 via-emerald-600 to-emerald-500 bg-clip-text font-semibold text-transparent opacity-0 animate-word-in animate-gradient-shift delay-400 motion-reduce:animate-none motion-reduce:opacity-100 dark:from-emerald-300 dark:via-emerald-400 dark:to-emerald-500">OS</span>
            </h1>
        </main>

        @include('components.command-modal')
    </body>
</html>
