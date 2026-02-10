@extends('layouts.app')

@section('content')

<x-hero :locale="app()->getLocale()" :is-rtl="$isRtl ?? false" />

<section id="skills" class="section">
    <div class="shell space-y-8">
        <div class="section-title">
            <span class="heading-accent">{{ __('home.skills.badge') }}</span>
            <h2>{{ __('home.skills.title') }}</h2>
            <p>{{ __('home.skills.subtitle') }}</p>
        </div>
        <div class="flex flex-wrap gap-3 text-xs text-[var(--muted)]">
            @foreach(__('home.skills.chips') as $chip)
                <span class="chip">{{ $chip }}</span>
            @endforeach
        </div>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach($skills as $group)
                <div class="surface p-5">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-[var(--text-strong)]">{{ $group['title'] }}</h3>
                        <span class="pill">{{ __('labels.senior') }}</span>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2 text-sm text-[var(--muted)]">
                        @foreach($group['items'] as $item)
                            <span class="chip">{{ $item }}</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="how" class="section">
    <div class="shell space-y-6">
        <div class="section-title">
            <span class="heading-accent">{{ __('home.how.badge') }}</span>
            <h2>{{ __('home.how.title') }}</h2>
            <p class="text-[var(--muted)]">{{ __('home.how.subtitle') }}</p>
        </div>
        <div class="grid gap-4 md:grid-cols-3">
            @foreach(__('home.how.steps') as $step)
                <div class="surface p-5 space-y-3">
                    <div class="pill">{{ $step['number'] }}</div>
                    <h3 class="text-lg font-semibold text-[var(--text-strong)]">{{ $step['title'] }}</h3>
                    <p class="text-sm text-[var(--muted)]">{{ $step['copy'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="why" class="section">
    <div class="shell space-y-6">
        <div class="section-title">
            <span class="heading-accent">{{ __('home.why.badge') }}</span>
            <h2>{{ __('home.why.title') }}</h2>
            <p class="text-[var(--muted)]">{{ __('home.why.subtitle') }}</p>
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div class="surface p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-[var(--text-strong)]">{{ __('home.why.agencies.title') }}</h3>
                    <span class="pill">{{ __('home.why.agencies.pill') }}</span>
                </div>
                <ul class="mt-4 space-y-2 text-sm text-[var(--muted)]">
                    @foreach(__('home.why.agencies.points') as $point)
                        <li>{{ $point }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="surface p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-[var(--text-strong)]">{{ __('home.why.me.title') }}</h3>
                    <span class="pill">{{ __('home.why.me.pill') }}</span>
                </div>
                <ul class="mt-4 space-y-2 text-sm text-[var(--muted)]">
                    @foreach(__('home.why.me.points') as $point)
                        <li>{{ $point }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="manifesto" class="section">
    <div class="shell space-y-4 text-center">
        <div class="section-title">
            <span class="heading-accent">{{ __('home.manifesto.badge') }}</span>
            <h2 class="text-3xl font-semibold text-[var(--text-strong)]">{{ __('home.manifesto.title') }}</h2>
        </div>
        <p class="mx-auto max-w-3xl text-[var(--muted)]">{{ __('home.manifesto.copy') }}</p>
    </div>
</section>

<section id="services" class="section">
    <div class="shell space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="section-title">
                <span class="heading-accent">{{ __('sections.services') }}</span>
                <h2>{{ __('sections.services') }}</h2>
                <p class="text-[var(--muted)]">{{ __('home.services.subtitle') }}</p>
            </div>
            <a class="btn-ghost" href="{{ route('services.index') }}">{{ __('cta.view_all') }}</a>
        </div>
        <div class="grid gap-6 md:grid-cols-2">
            @foreach($services as $service)
                <article class="surface p-6" data-reveal>
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="text-xl font-semibold text-[var(--text-strong)]">{{ $service->localized('title') }}</h3>
                        <span class="chip">{{ strtoupper($service->status) }}</span>
                    </div>
                    <p class="mt-3 text-sm text-[var(--muted)]">{{ $service->localized('excerpt') }}</p>
                    <div class="mt-4 flex flex-wrap gap-2 text-xs text-[var(--muted)]">
                        @foreach(($service->features ?? []) as $feature)
                            <span class="chip">{{ $feature }}</span>
                        @endforeach
                    </div>
                    <div class="mt-6 flex items-center justify-between">
                        <a class="text-[var(--accent)] font-semibold" href="{{ route('services.show', $service) }}">{{ __('cta.view_details') }}</a>
                        <span class="text-xs text-[var(--muted)]">{{ __('labels.starts_from') }} {{ $service->price_from ? '$'.number_format($service->price_from) : __('labels.custom_quote') }}</span>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="projects" class="section">
    <div class="shell space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="section-title">
                <span class="heading-accent">{{ __('sections.projects') }}</span>
                <h2>{{ __('sections.projects') }}</h2>
                <p class="text-[var(--muted)]">{{ __('home.projects.subtitle') }}</p>
            </div>
            <a class="btn-ghost" href="{{ route('projects.index') }}">{{ __('cta.view_all') }}</a>
        </div>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($projects as $project)
                <article class="surface p-5 space-y-4" data-reveal>
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-[var(--text-strong)]">{{ $project->localized('title') }}</h3>
                        @if($project->featured)
                            <span class="pill">{{ __('labels.featured') }}</span>
                        @endif
                    </div>
                    <div class="grid gap-3 text-sm text-[var(--muted)]">
                        <div>
                            <span class="text-[var(--text-strong)] font-semibold">{{ __('home.projects.problem') }}</span>
                            <p>{{ $project->localized('excerpt') }}</p>
                        </div>
                        <div>
                            <span class="text-[var(--text-strong)] font-semibold">{{ __('home.projects.solution') }}</span>
                            <p>{{ __('home.projects.solution_copy') }}</p>
                        </div>
                        <div>
                            <span class="text-[var(--text-strong)] font-semibold">{{ __('home.projects.stack') }}</span>
                            <div class="mt-2 flex flex-wrap gap-2 text-xs">
                                @foreach(array_slice($project->stack ?? [], 0, 5) as $tech)
                                    <span class="chip">{{ $tech }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 text-xs">
                            <div class="surface border border-[var(--card-2)] bg-[var(--card)] p-2 text-center">
                                <p class="text-[var(--muted)]">{{ __('home.projects.metrics.users') }}</p>
                                <p class="text-[var(--text-strong)] font-semibold">1k+</p>
                            </div>
                            <div class="surface border border-[var(--card-2)] bg-[var(--card)] p-2 text-center">
                                <p class="text-[var(--muted)]">{{ __('home.projects.metrics.perf') }}</p>
                                <p class="text-[var(--text-strong)] font-semibold">90+ LCP</p>
                            </div>
                            <div class="surface border border-[var(--card-2)] bg-[var(--card)] p-2 text-center">
                                <p class="text-[var(--muted)]">{{ __('home.projects.metrics.value') }}</p>
                                <p class="text-[var(--text-strong)] font-semibold">{{ __('home.projects.value_metric') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 flex items-center justify-between text-sm">
                        <a class="text-[var(--accent)] font-semibold" href="{{ route('projects.show', $project) }}">{{ __('cta.view_details') }}</a>
                        {{-- @if($project->live_url)
                            <a class="text-[var(--muted)] hover:text-[var(--text-strong)]" href="{{ $project->live_url }}" target="_blank" rel="noopener">{{ __('cta.visit_live') }}</a>
                        @endif --}}
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="trust" class="section">
    <div class="shell space-y-6">
        <div class="section-title">
            <span class="heading-accent">{{ __('home.trust.badge') }}</span>
            <h2>{{ __('home.trust.title') }}</h2>
            <p class="text-[var(--muted)]">{{ __('home.trust.subtitle') }}</p>
        </div>
        <div class="grid gap-4 md:grid-cols-3">
            @foreach(__('home.trust.tiles') as $tile)
                <div class="surface p-5 space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-[var(--text-strong)]">{{ $tile['title'] }}</h3>
                        <span class="pill">{{ $tile['pill'] }}</span>
                    </div>
                    @if(isset($tile['body']))
                        <p class="text-sm text-[var(--muted)]">{{ $tile['body'] }}</p>
                    @endif
                    @if(isset($tile['body_items']))
                        <ul class="space-y-2 text-sm text-[var(--muted)]">
                            @foreach($tile['body_items'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @endif
                    @if(isset($tile['href'], $tile['cta']))
                        <a class="btn-ghost" href="{{ $tile['href'] }}" target="_blank" rel="noreferrer">{{ $tile['cta'] }}</a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="blog" class="section">
    <div class="shell space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="section-title">
                <span class="heading-accent">{{ __('sections.blog') }}</span>
                <h2>{{ __('sections.blog') }}</h2>
                <p class="text-[var(--muted)]">{{ __('home.blog.subtitle') }}</p>
            </div>
            <a class="btn-ghost" href="{{ route('blog.index') }}">{{ __('cta.view_all') }}</a>
        </div>
        <div class="grid gap-6 md:grid-cols-3">
            @foreach($posts as $post)
                <article class="surface p-5" data-reveal>
                    <h3 class="text-lg font-semibold text-[var(--text-strong)]">{{ $post->localized('title') }}</h3>
                    <p class="mt-3 text-sm text-[var(--muted)]">{{ $post->localized('excerpt') }}</p>
                    <div class="mt-6 flex items-center justify-between text-sm">
                        <span class="text-[var(--muted)]">{{ $post->published_at?->translatedFormat('M d, Y') }}</span>
                        <a class="text-[var(--accent)] font-semibold" href="{{ route('blog.show', $post) }}">{{ __('cta.read') }}</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="conversion" class="section">
    <div class="shell space-y-6">
        <div class="section-title">
            <span class="heading-accent">{{ __('home.conversion.badge') }}</span>
            <h2>{{ __('home.conversion.title') }}</h2>
            <p class="text-[var(--muted)]">{{ __('home.conversion.subtitle') }}</p>
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div class="surface p-5 space-y-3">
                <h3 class="text-lg font-semibold text-[var(--text-strong)]">{{ __('home.conversion.lead_magnet.title') }}</h3>
                <p class="text-sm text-[var(--muted)]">{{ __('home.conversion.lead_magnet.copy') }}</p>
                <div class="flex flex-wrap gap-2 text-xs text-[var(--muted)]">
                    @foreach(__('home.conversion.lead_magnet.chips') as $chip)
                        <span class="chip">{{ $chip }}</span>
                    @endforeach
                </div>
                <div class="flex gap-3">
                    <a class="btn-primary" href="{{ route('contact.create') }}">{{ __('home.conversion.lead_magnet.primary') }}</a>
                    <a class="btn-ghost" href="https://wa.me/212" target="_blank" rel="noreferrer">{{ __('home.conversion.lead_magnet.secondary') }}</a>
                </div>
            </div>
            <div class="surface p-5 space-y-3">
                <h3 class="text-lg font-semibold text-[var(--text-strong)]">{{ __('home.conversion.quick_contact.title') }}</h3>
                <p class="text-sm text-[var(--muted)]">{{ __('home.conversion.quick_contact.copy') }}</p>
                <div class="flex gap-3">
                    <button class="btn-ghost" type="button" data-open-contact>{{ __('home.conversion.quick_contact.button') }}</button>
                    <a class="btn-ghost" href="mailto:{{ __('layout.footer.email') }}">{{ __('home.conversion.quick_contact.email') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="sticky bottom-4 inset-x-0 px-4">
    <div class="mx-auto flex max-w-4xl items-center justify-between gap-3 rounded-2xl border border-[var(--card-2)] bg-[var(--card)]/90 p-4 shadow-lg backdrop-blur">
        <div class="space-y-1">
            <p class="text-sm uppercase tracking-[0.2em] text-[var(--muted)]">{{ __('home.sticky.badge') }}</p>
            <p class="text-base font-semibold text-[var(--text-strong)]">{{ __('home.sticky.title') }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a class="btn-primary" href="{{ route('contact.create') }}">{{ __('home.sticky.primary') }}</a>
            <a class="btn-ghost" href="#projects">{{ __('home.sticky.secondary') }}</a>
        </div>
    </div>
</div>
@endsection
