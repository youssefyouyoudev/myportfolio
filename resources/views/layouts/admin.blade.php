<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ ($isRtl ?? false) ? 'rtl' : 'ltr' }}" data-theme="dark" class="{{ ($isRtl ?? false) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin · Devonter</title>
    <meta name="theme-color" content="#070b14">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen antialiased">
    <div class="flex min-h-screen">
        <aside class="hidden w-64 border-r border-[var(--border)] bg-[color-mix(in_srgb,var(--card)_85%,transparent)] px-5 py-6 text-sm text-[var(--muted)] backdrop-blur sm:block">
            <div class="mb-6 text-base font-semibold text-[var(--text-strong)]">Devonter Admin</div>
            <nav class="space-y-2">
                <a class="block rounded-lg px-3 py-2 text-[var(--muted)] transition hover:bg-[color-mix(in_srgb,var(--accent)_12%,transparent)] hover:text-[var(--text)]" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="block rounded-lg px-3 py-2 text-[var(--muted)] transition hover:bg-[color-mix(in_srgb,var(--accent)_12%,transparent)] hover:text-[var(--text)]" href="{{ route('admin.projects.index') }}">Projects</a>
                <a class="block rounded-lg px-3 py-2 text-[var(--muted)] transition hover:bg-[color-mix(in_srgb,var(--accent)_12%,transparent)] hover:text-[var(--text)]" href="{{ route('admin.tasks.index') }}">Tasks</a>
                <a class="block rounded-lg px-3 py-2 text-[var(--muted)] transition hover:bg-[color-mix(in_srgb,var(--accent)_12%,transparent)] hover:text-[var(--text)]" href="{{ route('admin.tasks.kanban') }}">Kanban</a>
                <a class="block rounded-lg px-3 py-2 text-[var(--muted)] transition hover:bg-[color-mix(in_srgb,var(--accent)_12%,transparent)] hover:text-[var(--text)]" href="{{ route('admin.tasks.gantt') }}">Gantt</a>
                <a class="block rounded-lg px-3 py-2 text-[var(--muted)] transition hover:bg-[color-mix(in_srgb,var(--accent)_12%,transparent)] hover:text-[var(--text)]" href="{{ route('admin.posts.index') }}">Blogs</a>
                <a class="block rounded-lg px-3 py-2 text-[var(--muted)] transition hover:bg-[color-mix(in_srgb,var(--accent)_12%,transparent)] hover:text-[var(--text)]" href="{{ route('admin.services.index') }}">Services</a>
                <a class="block rounded-lg px-3 py-2 text-[var(--muted)] transition hover:bg-[color-mix(in_srgb,var(--accent)_12%,transparent)] hover:text-[var(--text)]" href="{{ route('admin.leads.index') }}">Leads</a>
            </nav>
        </aside>
        <main class="flex-1 p-6">
            <div class="mb-6 flex items-center justify-between gap-4">
                <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-[var(--accent-2)] hover:opacity-80">Back to dashboard</a>
                <div class="flex items-center gap-3 text-sm text-[var(--muted)]">
                    <button type="button" class="theme-toggle" data-theme-toggle aria-label="Toggle theme">
                        <svg data-icon="sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <circle cx="12" cy="12" r="4" />
                            <path d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.5-7.5L17 5m-10 14-1.5 1.5m13 0L17 19m-10-14-1.5-1.5" />
                        </svg>
                        <svg data-icon="moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M21 13.5A9 9 0 1 1 10.5 3 7 7 0 0 0 21 13.5Z" />
                        </svg>
                    </button>
                    <span>{{ auth()->user()?->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-danger">Logout</button>
                    </form>
                </div>
            </div>
            @if(session('status'))
                <div class="mb-4 rounded-lg border border-[var(--border)] bg-[color-mix(in_srgb,var(--accent)_10%,transparent)] px-3 py-2 text-sm text-[var(--text)]">
                    {{ session('status') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
