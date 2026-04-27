@php
    $locale = app()->getLocale();
    $site = \App\Support\BrandContent::site($locale);
    $adminNav = [
        'Overview' => [
            [
                'label' => 'Dashboard',
                'href' => route('admin.dashboard', ['locale' => $locale]),
                'active' => request()->routeIs('admin.dashboard'),
                'meta' => 'Live',
            ],
        ],
        'Publishing' => [
            [
                'label' => 'Projects',
                'href' => route('admin.projects.index', ['locale' => $locale]),
                'active' => request()->routeIs('admin.projects.*'),
                'meta' => 'Case studies',
            ],
            [
                'label' => 'Blog Posts',
                'href' => route('admin.posts.index', ['locale' => $locale]),
                'active' => request()->routeIs('admin.posts.*'),
                'meta' => 'Insights',
            ],
            [
                'label' => 'Services',
                'href' => route('admin.services.index', ['locale' => $locale]),
                'active' => request()->routeIs('admin.services.*'),
                'meta' => 'Offers',
            ],
            [
                'label' => 'Testimonials',
                'href' => route('admin.testimonials.index', ['locale' => $locale]),
                'active' => request()->routeIs('admin.testimonials.*'),
                'meta' => 'Proof',
            ],
        ],
        'CRM' => [
            [
                'label' => 'Messages',
                'href' => route('admin.messages.index', ['locale' => $locale]),
                'active' => request()->routeIs('admin.messages.*'),
                'meta' => 'Inbox',
            ],
            [
                'label' => 'Leads',
                'href' => route('admin.leads.index', ['locale' => $locale]),
                'active' => request()->routeIs('admin.leads.*'),
                'meta' => 'Pipeline',
            ],
            [
                'label' => 'Lead Finder',
                'href' => route('admin.lead-finder.index', ['locale' => $locale]),
                'active' => request()->routeIs('admin.lead-finder.*'),
                'meta' => 'Agent',
            ],
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ ($isRtl ?? false) ? 'rtl' : 'ltr' }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') | {{ $site['name'] }}</title>
    <meta name="robots" content="noindex,nofollow">
    <meta name="theme-color" content="#071018">
    <link rel="icon" href="{{ asset('images/brand-mark.png') }}">
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
</head>
<body class="admin-body {{ ($isRtl ?? false) ? 'is-rtl' : '' }}">
    <div class="admin-shell">
        <aside class="admin-sidebar panel">
            <a href="{{ route('admin.dashboard', ['locale' => $locale]) }}" class="admin-brand">
                <span class="brand-mark">
                    <img src="{{ asset('images/brand-mark.png') }}" alt="{{ $site['name'] }}">
                </span>
                <span class="admin-brand-copy">
                    <strong>{{ $site['name'] }}</strong>
                    <small>Private admin workspace</small>
                </span>
            </a>

            <div class="admin-sidebar-copy">
                <span class="eyebrow">Admin workspace</span>
                <p>Simple, private, and built for fast publishing, follow-up, and lead review.</p>
            </div>

            <nav class="admin-nav" aria-label="Admin navigation">
                @foreach($adminNav as $group => $items)
                    <div class="admin-nav-group">
                        <span class="admin-nav-heading">{{ $group }}</span>
                        @foreach($items as $item)
                            <a href="{{ $item['href'] }}" @class(['admin-nav-link', 'is-active' => $item['active']]) @if($item['active']) aria-current="page" @endif>
                                <span>{{ $item['label'] }}</span>
                                <small>{{ $item['meta'] }}</small>
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </nav>

            <div class="admin-sidebar-foot">
                <p>Protected by authentication and admin-only access.</p>
            </div>
        </aside>

        <main class="admin-main">
            <header class="admin-topbar panel">
                <div class="admin-topbar-copy">
                    <span class="eyebrow">Private admin</span>
                    <h1>@yield('admin_title', 'Dashboard')</h1>
                    <p>@yield('admin_copy', 'A clean foundation for managing the portfolio behind the scenes.') </p>
                </div>

                <div class="admin-topbar-actions">
                    <button type="button" class="theme-toggle" data-theme-toggle aria-label="Toggle theme">
                        <svg data-theme-icon="sun" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="4"></circle>
                            <path d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.5-7.5L17 5m-10 14-1.5 1.5m13 0L17 19m-10-14L5.5 3.5"></path>
                        </svg>
                        <svg data-theme-icon="moon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M21 13.2A8.8 8.8 0 0 1 10.8 3a9 9 0 1 0 10.2 10.2Z"></path>
                        </svg>
                    </button>
                    <a href="{{ route('home', ['locale' => $locale]) }}" class="btn btn-secondary btn-compact">View website</a>
                    <div class="admin-user-chip">
                        <strong>{{ auth()->user()?->name }}</strong>
                        <span>{{ auth()->user()?->email }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-compact">Logout</button>
                    </form>
                </div>
            </header>

            @if(session('status'))
                <div class="status-banner" role="status" aria-live="polite">{{ session('status') }}</div>
            @endif
            @if($errors->any())
                <div class="status-banner status-banner-error" role="alert">
                    Please review the highlighted fields and try again.
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
