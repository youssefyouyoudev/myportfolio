<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ ($isRtl ?? false) ? 'rtl' : 'ltr' }}" data-theme="dark" class="{{ ($isRtl ?? false) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Youssef Youyou — Full-Stack Engineer & Product Builder') }}</title>
    <meta name="description" content="Youssef Youyou — Full-Stack Engineer &amp; Product Builder from Morocco. I design, build, and launch SaaS platforms using Laravel, React, and Node.js. Remote-friendly." />
    <meta name="keywords" content="Full-stack developer Morocco, Laravel developer, React developer, SaaS developer, freelance web developer, Youssef Youyou" />
    <meta property="og:title" content="Youssef Youyou — Full-Stack Engineer &amp; Product Builder" />
    <meta property="og:description" content="I design, build, and launch revenue-grade platforms. Founder-minded delivery for teams that need a product owner who ships fast." />
    <meta property="og:url" content="https://www.youssefyouyou.com" />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Youssef Youyou — Full-Stack Engineer" />
    <meta name="twitter:description" content="Building SaaS, fintech, and product platforms from Morocco. Laravel · React · Node.js." />
    <meta name="theme-color" content="#070b14">
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
                        <img src="{{ asset('images/avatar.png') }}" alt="Avatar" class="h-9 w-9 object-contain" />
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
                        <a class="hover:text-[var(--accent)]" href="https://github.com/youssefyouyoudev" target="_blank" rel="noopener noreferrer">GitHub</a>
                        <a class="hover:text-[var(--accent)]" href="https://linkedin.com/in/youssefyouyoudev" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                    </div>
                    <div class="text-[var(--muted)]">{{ str_replace(':year', now()->year, __('layout.footer.copyright')) }}</div>
                </div>
            </div>
        </footer>
    </div>

    {{-- Sticky floating WhatsApp CTA --}}
    <a
        href="https://wa.me/212610090070"
        target="_blank"
        rel="noopener noreferrer"
        class="whatsapp-fab"
        aria-label="Chat on WhatsApp"
        title="Chat on WhatsApp"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
    </a>
    <style>
        .whatsapp-fab {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3.25rem;
            height: 3.25rem;
            border-radius: 9999px;
            background-color: #25d366;
            color: #fff;
            box-shadow: 0 4px 18px rgba(37, 211, 102, 0.45);
            transition: transform 0.2s, box-shadow 0.2s;
            opacity: 0;
            animation: whatsapp-fadein 0.5s ease forwards 2s;
        }
        .whatsapp-fab:hover {
            transform: translateY(-3px) scale(1.07);
            box-shadow: 0 8px 26px rgba(37, 211, 102, 0.55);
        }
        @keyframes whatsapp-fadein {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>
