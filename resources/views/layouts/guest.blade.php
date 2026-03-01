<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Devonter Portfolio Platform') }}</title>
        <meta name="theme-color" content="#ef4444">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen antialiased">
        <main class="shell flex min-h-screen items-center justify-center py-10">
            <div class="auth-wrap space-y-5">
                <a href="{{ route('home') }}" class="mx-auto flex w-fit items-center gap-3" aria-label="Back home">
                    <span class="soft-badge shadow-soft relative inline-flex h-12 w-12 items-center justify-center rounded-full">
                        <img src="{{ asset('images/avatar.png') }}" alt="Avatar" class="h-9 w-9 object-contain" />
                    </span>
                    <span class="text-sm font-semibold text-[var(--text-strong)]">{{ config('app.author_name', 'Youssef Youyou') }}</span>
                </a>

                <div class="auth-card">
                    @yield('content')
                </div>
            </div>
        </main>
    </body>
</html>
