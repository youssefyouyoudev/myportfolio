@php
    $locale = app()->getLocale();
    $site = \App\Support\BrandContent::site($locale);
    $landing = \App\Support\BrandContent::landing($locale);
    $meta = array_merge($site['default_seo'], $seo ?? []);
    $homeUrl = route('home', ['locale' => $locale]);
    $anchorBase = \Illuminate\Support\Facades\Route::currentRouteNamed('home') ? '' : $homeUrl;
    $alternateLocales = \App\Support\BrandContent::supportedLocales();
    $currentRouteName = \Illuminate\Support\Facades\Route::currentRouteName() ?? 'home';
    $currentRouteParameters = request()->route()?->parameters() ?? [];
    $localeLabels = collect($alternateLocales)->mapWithKeys(
        fn (string $supportedLocale): array => [$supportedLocale => \App\Support\BrandContent::localeName($supportedLocale)]
    );
    $localeLinks = collect($alternateLocales)->mapWithKeys(
        fn (string $supportedLocale): array => [
            $supportedLocale => route($currentRouteName, array_filter(array_merge($currentRouteParameters, ['locale' => $supportedLocale])))
        ]
    );
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ ($isRtl ?? false) ? 'rtl' : 'ltr' }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <meta name="theme-color" content="#050816">
    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:type" content="{{ $meta['type'] ?? 'website' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/brand-mark.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $meta['title'] }}">
    <meta name="twitter:description" content="{{ $meta['description'] }}">
    <meta name="twitter:image" content="{{ asset('images/brand-mark.png') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    @foreach($alternateLocales as $alternateLocale)
        <link rel="alternate" hreflang="{{ $alternateLocale }}" href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName() ?? 'home', array_filter(array_merge(request()->route()?->parameters() ?? [], ['locale' => $alternateLocale]))) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ route('home', ['locale' => 'en']) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @foreach(($meta['schema'] ?? []) as $schema)
        <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    @endforeach
</head>
<body class="{{ ($isRtl ?? false) ? 'is-rtl' : '' }}">
    <div class="site-shell">
        <header class="site-header">
            <div class="container header-panel">
                <div class="header-row">
                    <a href="{{ $homeUrl }}" class="brand-lockup" aria-label="{{ $site['name'] }}">
                        <span class="brand-mark">
                            <img src="{{ asset('images/brand-mark.png') }}" alt="{{ $site['name'] }}">
                        </span>
                        <span class="brand-copy">
                            <strong>{{ $site['name'] }}</strong>
                            <small>{{ $site['role'] }}</small>
                        </span>
                    </a>

                    <nav class="desktop-nav" aria-label="Primary">
                        <a href="{{ route('about', ['locale' => $locale]) }}">{{ $landing['nav']['about'] }}</a>
                        <a href="{{ route('services.index', ['locale' => $locale]) }}">{{ $landing['nav']['services'] }}</a>
                        <a href="{{ route('projects.index', ['locale' => $locale]) }}">{{ $landing['nav']['projects'] }}</a>
                        <a href="{{ route('skills', ['locale' => $locale]) }}">{{ $landing['nav']['expertise'] }}</a>
                        <a href="{{ route('contact.create', ['locale' => $locale]) }}">{{ $landing['nav']['contact'] }}</a>
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
                        <button type="button" class="theme-toggle" data-theme-toggle aria-label="Toggle theme">
                            <svg data-theme-icon="sun" viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="12" r="4"></circle>
                                <path d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.5-7.5L17 5m-10 14-1.5 1.5m13 0L17 19m-10-14L5.5 3.5"></path>
                            </svg>
                            <svg data-theme-icon="moon" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M21 13.2A8.8 8.8 0 0 1 10.8 3a9 9 0 1 0 10.2 10.2Z"></path>
                            </svg>
                        </button>
                        <a href="{{ route('contact.create', ['locale' => $locale]) }}" class="btn btn-primary header-cta">{{ $landing['nav']['start_project'] }}</a>
                    </div>
                </div>

                <details class="mobile-nav">
                    <summary>Menu</summary>
                    <div class="mobile-nav-panel">
                        <a href="{{ route('about', ['locale' => $locale]) }}">{{ $landing['nav']['about'] }}</a>
                        <a href="{{ route('services.index', ['locale' => $locale]) }}">{{ $landing['nav']['services'] }}</a>
                        <a href="{{ route('projects.index', ['locale' => $locale]) }}">{{ $landing['nav']['projects'] }}</a>
                        <a href="{{ route('skills', ['locale' => $locale]) }}">{{ $landing['nav']['expertise'] }}</a>
                        <a href="{{ route('industries', ['locale' => $locale]) }}">{{ $landing['nav']['industries'] }}</a>
                        <a href="{{ route('blog.index', ['locale' => $locale]) }}">{{ $landing['nav']['insights'] }}</a>
                        <a href="{{ route('availability', ['locale' => $locale]) }}">{{ $landing['nav']['hire'] }}</a>
                        <a href="{{ route('contact.create', ['locale' => $locale]) }}">{{ $landing['nav']['contact'] }}</a>
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
                        <button type="button" class="theme-toggle mobile-theme" data-theme-toggle aria-label="Toggle theme">
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

        <main>
            @yield('content')
        </main>

        <footer class="site-footer">
            <div class="container footer-panel">
                <div class="footer-grid">
                    <div class="footer-intro">
                        <span class="eyebrow">{{ $landing['nav']['footer_eyebrow'] }}</span>
                        <h3>{{ $landing['nav']['footer_title'] }}</h3>
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
                        <a href="mailto:{{ $site['email'] }}">{{ $site['email'] }}</a>
                        <a href="tel:+212610090070">{{ $site['phone'] }}</a>
                        <a href="https://wa.me/212610090070" target="_blank" rel="noopener">WhatsApp</a>
                        <a href="https://github.com/youssefyouyoudev" target="_blank" rel="noopener">GitHub</a>
                        <a href="https://linkedin.com/in/youssefyouyoudev" target="_blank" rel="noopener">LinkedIn</a>
                        <div class="footer-locales">
                            @foreach($localeLabels as $supportedLocale => $label)
                                <a href="{{ $localeLinks[$supportedLocale] }}">{{ $label }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>&copy; {{ now()->year }} {{ $site['name'] }}. Built for modern client acquisition.</p>
                </div>
            </div>
        </footer>
    </div>

    <a href="https://wa.me/212610090070" class="whatsapp-fab" target="_blank" rel="noopener" aria-label="WhatsApp">WhatsApp</a>
</body>
</html>
