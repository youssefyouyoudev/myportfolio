@php
    $locale = app()->getLocale();
    $site = \App\Support\BrandContent::site($locale);
    $landing = \App\Support\BrandContent::landing($locale);
    $meta = $seo ?? [];
    $homeUrl = route('home', ['locale' => $locale]);
    $alternateLocales = \App\Support\BrandContent::supportedLocales();
    $currentRouteName = \Illuminate\Support\Facades\Route::currentRouteName() ?? 'home';
    $currentRouteParameters = request()->route()?->parameters() ?? [];
    $ogLocales = [
        'en' => 'en_US',
        'fr' => 'fr_FR',
        'ar' => 'ar_MA',
        'es' => 'es_ES',
        'de' => 'de_DE',
    ];
        $localeLabels = collect($alternateLocales)->mapWithKeys(
        fn (string $supportedLocale): array => [$supportedLocale => match ($supportedLocale) {
            'en' => 'English',
            'fr' => 'French',
            'ar' => 'Arabic',
            'es' => 'Spanish',
            'de' => 'German',
            default => \App\Support\BrandContent::localeName($supportedLocale),
        }]
    );
    $localeLinks = collect($alternateLocales)->mapWithKeys(
        fn (string $supportedLocale): array => [
            $supportedLocale => route($currentRouteName, array_filter(array_merge($currentRouteParameters, ['locale' => $supportedLocale])))
        ]
    );
    $primaryNav = [
        [
            'label' => $landing['nav']['services'],
            'url'   => route('services.index', ['locale' => $locale]),
            'active' => str_starts_with($currentRouteName, 'services.'),
        ],
        [
            'label' => $landing['nav']['projects'],
            'url'   => route('projects.index', ['locale' => $locale]),
            'active' => str_starts_with($currentRouteName, 'projects.'),
        ],
        [
            'label' => $landing['nav']['process'],
            'url'   => route('process.page', ['locale' => $locale]),
            'active' => in_array($currentRouteName, ['process.page'], true),
        ],
        [
            'label' => $landing['nav']['about'],
            'url'   => route('about', ['locale' => $locale]),
            'active' => $currentRouteName === 'about',
        ],
        [
            'label' => $landing['nav']['insights'],
            'url'   => route('blog.index', ['locale' => $locale]),
            'active' => str_starts_with($currentRouteName, 'blog.'),
        ],
        [
            'label' => 'Contact',
            'url'   => route('contact.create', ['locale' => $locale]),
            'active' => str_starts_with($currentRouteName, 'contact.'),
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ ($isRtl ?? false) ? 'rtl' : 'ltr' }}" data-theme="dark">
<head>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1914940263140841"
     crossorigin="anonymous"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('layouts.partials.seo', [
        'site' => $site,
        'meta' => $meta,
        'locale' => $locale,
        'ogLocales' => $ogLocales,
        'alternateLocales' => $alternateLocales,
    ])
    <link rel="preload" href="{{ asset('images/brand-mark.png') }}" as="image">
    @if(($currentRouteName ?? null) === 'home')
        <link rel="preload" href="{{ asset('images/youssef-youyou.jpg') }}" as="image">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script>
        (() => {
            const key = 'yy-theme';
            const root = document.documentElement;
            const stored = localStorage.getItem(key);
            const system = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = stored === 'light' || stored === 'dark' ? stored : system;
            root.dataset.theme = theme;
            root.style.colorScheme = theme;
        })();
    </script>
    @stack('structured-data')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="{{ ($isRtl ?? false) ? 'is-rtl' : '' }}">
    <a href="#main-content" class="skip-link">{{ __('brand.ui.layout.skip_to_content') }}</a>
    <div class="site-shell">
        <header class="site-header">
            <div class="container header-panel">
                <div class="header-row">
                    <a href="{{ $homeUrl }}" class="brand-lockup" aria-label="{{ $site['name'] }}">
                        <span class="brand-mark">
                            <img src="{{ asset('images/brand-mark.png') }}" alt="{{ $site['name'] }}" width="40" height="40" loading="eager" fetchpriority="high">
                        </span>
                        <span class="brand-copy">
                            <strong>{{ $site['name'] }}</strong>
                            <small>{{ $site['role'] }}</small>
                        </span>
                    </a>

                    <nav class="desktop-nav" aria-label="{{ $landing['nav']['navigate'] }}">
                        @foreach($primaryNav as $item)
                            <a href="{{ $item['url'] }}" @class(['nav-link', 'is-active' => $item['active']]) @if($item['active']) aria-current="page" @endif>{{ $item['label'] }}</a>
                        @endforeach
                    </nav>

                    <div class="header-actions">
                        <details class="locale-menu header-locale">
                            <summary class="locale-trigger">
                                <span>{{ $localeLabels[$locale] ?? strtoupper($locale) }}</span>
                                <svg viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="m5 7 5 6 5-6"></path>
                                </svg>
                            </summary>
                            <div class="locale-list" role="listbox" aria-label="{{ $landing['nav']['language'] }}">
                                @foreach($localeLabels as $supportedLocale => $label)
                                    <a href="{{ $localeLinks[$supportedLocale] }}" @class(['is-active' => $locale === $supportedLocale])>{{ $label }}</a>
                                @endforeach
                            </div>
                        </details>
                        <button type="button" class="theme-toggle" data-theme-toggle aria-label="{{ $site['theme']['toggle'] }}">
                            <svg data-theme-icon="sun" viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="12" r="4"></circle>
                                <path d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.5-7.5L17 5m-10 14-1.5 1.5m13 0L17 19m-10-14L5.5 3.5"></path>
                            </svg>
                            <svg data-theme-icon="moon" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M21 13.2A8.8 8.8 0 0 1 10.8 3a9 9 0 1 0 10.2 10.2Z"></path>
                            </svg>
                        </button>
                        <a href="{{ route('availability', ['locale' => $locale]) }}" class="header-status">
                            <span class="avail-label">{{ $site['availability_badge']['label'] }}</span>
                            <span>{{ $site['availability_badge']['detail'] }}</span>
                        </a>
                        <a href="{{ route('contact.create', ['locale' => $locale]) }}" class="btn btn-primary header-cta" id="nav-cta-start">{{ $landing['nav']['start_project'] }}</a>
                    </div>
                </div>

                <details class="mobile-nav">
                    <summary>{{ __('brand.ui.layout.menu') }}</summary>
                    <div class="mobile-nav-panel">
                        @foreach($primaryNav as $item)
                            <a href="{{ $item['url'] }}" @class(['nav-link', 'is-active' => $item['active']]) @if($item['active']) aria-current="page" @endif>{{ $item['label'] }}</a>
                        @endforeach
                        <a href="{{ route('contact.create', ['locale' => $locale]) }}" @class(['nav-link', 'is-active' => str_starts_with($currentRouteName, 'contact.')]) @if(str_starts_with($currentRouteName, 'contact.')) aria-current="page" @endif>{{ $landing['nav']['contact'] }}</a>
                        <a href="{{ route('industries', ['locale' => $locale]) }}">{{ $landing['nav']['industries'] }}</a>
                        <a href="{{ route('availability', ['locale' => $locale]) }}">{{ $landing['nav']['hire'] }}</a>
                        <details class="locale-menu mobile-locale-menu">
                            <summary class="locale-trigger">
                                <span>{{ $landing['nav']['language'] }}: {{ $localeLabels[$locale] ?? strtoupper($locale) }}</span>
                                <svg viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="m5 7 5 6 5-6"></path>
                                </svg>
                            </summary>
                            <div class="locale-list" role="listbox" aria-label="{{ $landing['nav']['language'] }}">
                                @foreach($localeLabels as $supportedLocale => $label)
                                    <a href="{{ $localeLinks[$supportedLocale] }}" @class(['is-active' => $locale === $supportedLocale])>{{ $label }}</a>
                                @endforeach
                            </div>
                        </details>
                        <button type="button" class="theme-toggle mobile-theme" data-theme-toggle aria-label="{{ $site['theme']['toggle'] }}">
                            <svg data-theme-icon="sun" viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="12" r="4"></circle>
                                <path d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.5-7.5L17 5m-10 14-1.5 1.5m13 0L17 19m-10-14L5.5 3.5"></path>
                            </svg>
                            <svg data-theme-icon="moon" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M21 13.2A8.8 8.8 0 0 1 10.8 3a9 9 0 1 0 10.2 10.2Z"></path>
                            </svg>
                        </button>
                        <a href="{{ route('contact.create', ['locale' => $locale]) }}" class="btn btn-primary">{{ $landing['nav']['start_project'] }}</a>
                    </div>
                </details>
            </div>
        </header>

        <main id="main-content">
            @yield('content')
        </main>

        <footer class="site-footer">
            <div class="container footer-panel">
                <div class="footer-grid">
                    <div class="footer-intro">
                        <span class="eyebrow">{{ $landing['nav']['footer_eyebrow'] }}</span>
                        <p class="footer-title">{{ $landing['nav']['footer_title'] }}</p>
                        <p>{{ $landing['nav']['footer_copy'] }}</p>
                    </div>
                    <div class="footer-column">
                        <h4>{{ $landing['nav']['navigate'] }}</h4>
                        <a href="{{ route('services.index', ['locale' => $locale]) }}">{{ $landing['nav']['services'] }}</a>
                        <a href="{{ route('projects.index', ['locale' => $locale]) }}">{{ $landing['nav']['projects'] }}</a>
                        <a href="{{ route('skills', ['locale' => $locale]) }}">{{ $landing['nav']['expertise'] }}</a>
                        <a href="{{ route('tech-stack', ['locale' => $locale]) }}">{{ $landing['nav']['tech_stack'] }}</a>
                        <a href="{{ route('industries', ['locale' => $locale]) }}">{{ $landing['nav']['industries'] }}</a>
                        <a href="{{ route('process.page', ['locale' => $locale]) }}">{{ $landing['nav']['process'] }}</a>
                    </div>
                    <div class="footer-column">
                        <h4>{{ $landing['nav']['reach_out'] }}</h4>
                        <a href="{{ $site['email_link'] }}">{{ $site['email'] }}</a>
                        <a href="{{ $site['phone_link'] }}">{{ $site['phone'] }}</a>
                        <a href="{{ $site['whatsapp_url'] }}" target="_blank" rel="noopener" aria-label="WhatsApp {{ $site['phone'] }}">{{ $site['actions']['whatsapp'] }}</a>
                        @foreach($site['socials'] as $social)
                            <a href="{{ $social['url'] }}" target="_blank" rel="me noopener" aria-label="{{ $social['label'] }}">{{ $social['label'] }}</a>
                        @endforeach
                        <div class="footer-locales">
                            @foreach($localeLabels as $supportedLocale => $label)
                                <a href="{{ $localeLinks[$supportedLocale] }}">{{ $label }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>{{ __('brand.ui.layout.footer_bottom', ['year' => now()->year, 'name' => $site['name'], 'location' => $site['location']]) }}</p>
                </div>
            </div>
        </footer>
    </div>

    <a href="https://wa.me/212610090070" class="whatsapp-fab" data-delayed-whatsapp target="_blank" rel="noopener" aria-label="{{ $site['actions']['whatsapp'] }}">
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M19.05 4.94A9.93 9.93 0 0 0 12 2a10 10 0 0 0-8.66 15l-1.3 4.74 4.87-1.28A10 10 0 1 0 19.05 4.94Zm-7.05 15.39a8.27 8.27 0 0 1-4.22-1.16l-.3-.18-2.89.76.77-2.82-.19-.3A8.34 8.34 0 1 1 12 20.33Zm4.58-6.26c-.25-.12-1.47-.73-1.7-.81-.23-.08-.39-.12-.56.12-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.12-1.04-.38-1.98-1.22-.73-.65-1.22-1.45-1.36-1.7-.14-.25-.02-.38.1-.5.11-.11.25-.29.37-.43.12-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.35-.76-1.85-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.23.25-.87.85-.87 2.06s.89 2.39 1.02 2.56c.12.17 1.74 2.65 4.21 3.72.59.25 1.05.4 1.41.51.59.19 1.12.16 1.54.1.47-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.11-.23-.17-.48-.29Z"></path>
        </svg>
        <span class="sr-only">{{ $site['actions']['whatsapp'] }}</span>
    </a>
    <div class="mobile-cta-bar" aria-label="Quick actions">
        <a href="{{ route('contact.create', ['locale' => $locale]) }}" class="btn btn-primary">{{ $landing['nav']['start_project'] }}</a>
        <a href="{{ $site['whatsapp_url'] }}" class="btn btn-secondary" target="_blank" rel="noopener">{{ $site['actions']['whatsapp'] }}</a>
    </div>
</body>
</html>
