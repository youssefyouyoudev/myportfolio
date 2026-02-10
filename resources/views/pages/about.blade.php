@extends('layouts.app')

@section('content')
<section class="section">
    <div class="shell space-y-8">
        <div class="section-title">
            <span class="heading-accent">{{ __('sections.about') }}</span>
            <h1 class="text-3xl font-semibold text-[var(--text-strong)]">{{ __('about.title') }}</h1>
            <p class="text-lg text-[var(--muted)]">{{ __('about.lead') }}</p>
        </div>
        <div class="grid gap-6 md:grid-cols-3">
            <div class="surface p-5">
                <h3 class="text-lg font-semibold text-[var(--text-strong)]">{{ __('about.background') }}</h3>
                <p class="mt-3 text-sm text-[var(--muted)]">{{ __('about.background_copy') }}</p>
            </div>
            <div class="surface p-5">
                <h3 class="text-lg font-semibold text-[var(--text-strong)]">{{ __('about.stack') }}</h3>
                <ul class="mt-3 space-y-2 text-sm text-[var(--muted)]">
                    <li>Laravel, React, Vite, Tailwind</li>
                    <li>Node.js, Express, MongoDB, PostgreSQL</li>
                    <li>Android (NFC), Kotlin/Java, Play Store</li>
                    <li>Python desktop (Tkinter) with SQLite</li>
                    <li>CI/CD, Docker, AWS, Forge/Vapor</li>
                </ul>
            </div>
            <div class="surface p-5">
                <h3 class="text-lg font-semibold text-[var(--text-strong)]">{{ __('about.values') }}</h3>
                <ul class="mt-3 space-y-2 text-sm text-[var(--muted)]">
                    <li>{{ __('about.values_delivery') }}</li>
                    <li>{{ __('about.values_quality') }}</li>
                    <li>{{ __('about.values_partnership') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
