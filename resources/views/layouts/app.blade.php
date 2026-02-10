<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ ($isRtl ?? false) ? 'rtl' : 'ltr' }}" data-theme="dark" class="{{ ($isRtl ?? false) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Devonter Portfolio Platform') }}</title>
    <meta name="description" content="{{ __('layout.meta_description') }}">
    <meta name="theme-color" content="#0fa3a8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen antialiased">
    <div class="relative flex min-h-screen flex-col">
        <header class="sticky top-0 z-40 glass-header">
            <div class="shell flex items-center justify-between gap-4 py-4">
                <a href="/" class="group flex items-center gap-3" aria-label="{{ __('navigation.back_home') }}">
                    <span class="soft-badge shadow-soft relative inline-flex h-12 w-12 items-center justify-center rounded-full">
                        <img src="{{ Vite::asset('resources/images/avatar.png') }}" alt="Avatar" class="h-9 w-9 object-contain" />
                    </span>
                    <div>
                        <div class="text-xs uppercase tracking-[0.22em] text-[var(--muted)]">{{ config('app.author_name', 'Youssef Youyou') }}</div>
                        <div class="text-base font-semibold text-[var(--text-strong)] leading-tight">{{ config('app.author_title', 'Full-Stack Engineer') }} · {{ __('layout.location') }}</div>
                        <div class="text-[13px] text-[var(--muted)]">{{ __('layout.subtitle') }}</div>
                    </div>
                </a>
                <nav class="hidden items-center gap-1 md:flex">
                    <a class="nav-link {{ request()->is('services*') ? 'is-active' : '' }}" href="#services">{{ __('navigation.services') }}</a>
                    <a class="nav-link {{ request()->is('projects*') ? 'is-active' : '' }}" href="#projects">{{ __('navigation.projects') }}</a>
                    <a class="nav-link {{ request()->is('blog*') ? 'is-active' : '' }}" href="#blog">{{ __('navigation.blog') }}</a>
                    <a class="nav-link {{ request()->is('contact') ? 'is-active' : '' }}" href="{{ route('contact.create') }}">{{ __('navigation.contact') }}</a>
                </nav>
                <div class="flex items-center gap-2">
                    <form method="get" action="{{ url()->current() }}" class="hidden sm:block">
                        <select name="lang" id="lang" class="input-ghost text-xs font-semibold" data-lang-select>
                            @foreach(['en' => 'EN', 'fr' => 'FR', 'ar' => 'AR'] as $code => $label)
                                <option value="{{ $code }}" @selected(app()->getLocale() === $code)> {{ $label }}</option>
                            @endforeach
                        </select>
                    </form>
                    <button type="button" class="theme-toggle" data-theme-toggle aria-label="{{ __('navigation.toggle_theme') }}">
                        <svg data-icon="sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <circle cx="12" cy="12" r="4" />
                            <path d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.5-7.5L17 5m-10 14-1.5 1.5m13 0L17 19m-10-14-1.5-1.5" />
                        </svg>
                        <svg data-icon="moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M21 13.5A9 9 0 1 1 10.5 3 7 7 0 0 0 21 13.5Z" />
                        </svg>
                    </button>
                    <a href="{{ route('contact.create') }}" class="hidden sm:inline-flex btn-primary text-sm">
                        {{ __('cta.hire_me') }}
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </header>

        <main class="flex-1">
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        <footer class="section glass-footer">
            <div class="shell footer-grid">
                <div class="space-y-2">
                    <span class="heading-accent">{{ __('navigation.tagline') }}</span>
                    <p class="text-[var(--muted)]">{{ __('layout.footer.body') }}</p>
                    <div class="flex flex-wrap gap-2">
                        <a class="btn-primary" href="{{ route('contact.create') }}">{{ __('cta.hire_me') }}</a>
                        <a class="btn-ghost" href="#projects">{{ __('cta.view_work') }}</a>
                    </div>
                </div>
                <div class="space-y-2 text-sm text-[var(--muted)]">
                    <div class="flex items-center gap-3">
                        <span class="h-2 w-2 rounded-full bg-[var(--accent)]"></span>
                        <span>{{ __('layout.footer.location') }}</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-4">
                        <a class="hover:text-[var(--accent)]" href="mailto:{{ __('layout.footer.email') }}">{{ __('layout.footer.email') }}</a>
                        <a class="hover:text-[var(--accent)]" href="https://github.com/youssefyouyoudev" target="_blank" rel="noreferrer">GitHub</a>
                        <a class="hover:text-[var(--accent)]" href="https://www.linkedin.com/in/youssef-youyou/" target="_blank" rel="noreferrer">LinkedIn</a>
                    </div>
                    <div class="text-[var(--muted)]">{{ str_replace(':year', now()->year, __('layout.footer.copyright')) }}</div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
