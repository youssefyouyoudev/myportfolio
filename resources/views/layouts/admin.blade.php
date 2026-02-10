<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ ($isRtl ?? false) ? 'rtl' : 'ltr' }}" class="{{ ($isRtl ?? false) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin · Devonter</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen antialiased">
    <div class="flex min-h-screen">
        <aside class="hidden w-64 border-r border-[var(--border)] bg-[color-mix(in_srgb,var(--card)_85%,transparent)] px-5 py-6 text-sm text-[var(--muted)] backdrop-blur sm:block">
            <div class="mb-6 text-base font-semibold text-[var(--text-strong)]">Devonter Admin</div>
            <nav class="space-y-2">
                <a class="block rounded-lg px-3 py-2 text-[var(--muted)] transition hover:bg-[color-mix(in_srgb,var(--accent)_12%,transparent)] hover:text-[var(--text)]" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="block rounded-lg px-3 py-2 text-[var(--muted)] transition hover:bg-[color-mix(in_srgb,var(--accent)_12%,transparent)] hover:text-[var(--text)]" href="{{ route('admin.projects.index') }}">Projects</a>
                <a class="block rounded-lg px-3 py-2 text-[var(--muted)] transition hover:bg-[color-mix(in_srgb,var(--accent)_12%,transparent)] hover:text-[var(--text)]" href="{{ route('admin.services.index') }}">Services</a>
                <a class="block rounded-lg px-3 py-2 text-[var(--muted)] transition hover:bg-[color-mix(in_srgb,var(--accent)_12%,transparent)] hover:text-[var(--text)]" href="{{ route('admin.posts.index') }}">Posts</a>
                <a class="block rounded-lg px-3 py-2 text-[var(--muted)] transition hover:bg-[color-mix(in_srgb,var(--accent)_12%,transparent)] hover:text-[var(--text)]" href="{{ route('admin.leads.index') }}">Leads</a>
            </nav>
        </aside>
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
