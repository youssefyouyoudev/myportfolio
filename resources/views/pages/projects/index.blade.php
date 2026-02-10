@extends('layouts.app')

@section('content')
<section class="section">
    <div class="mx-auto max-w-6xl px-6">
        <div class="flex items-center justify-between">
            <div class="section-title">
                <span class="heading-accent">{{ __('sections.projects') }}</span>
                <h1 class="text-3xl font-semibold text-[var(--text-strong)]">{{ __('sections.projects') }}</h1>
                <p class="text-[var(--muted)]">{{ $projects->total() }} {{ __('labels.projects') }}</p>
            </div>
            <span class="chip">{{ $projects->total() }} {{ __('labels.live') }}</span>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($projects as $project)
                <article class="surface p-5" data-reveal>
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-[var(--text-strong)]">{{ $project->localized('title') }}</h2>
                        @if($project->featured)
                            <span class="pill">{{ __('labels.featured') }}</span>
                        @endif
                    </div>
                    <p class="mt-3 text-sm text-[var(--muted)]">{{ $project->localized('excerpt') }}</p>
                    <div class="mt-4 flex flex-wrap gap-2 text-xs text-[var(--muted)]">
                        @foreach(array_slice($project->stack ?? [], 0, 6) as $tech)
                            <span class="chip">{{ $tech }}</span>
                        @endforeach
                    </div>
                    <div class="mt-6 flex items-center justify-between text-sm">
                        <a class="text-[var(--accent)] font-semibold" href="{{ route('projects.show', $project) }}">{{ __('cta.view_details') }}</a>
                        {{-- @if($project->live_url)
                            <a class="text-[var(--muted)] hover:text-[var(--text-strong)]" href="{{ $project->live_url }}" target="_blank" rel="noopener">{{ __('cta.visit_live') }}</a>
                        @endif --}}
                    </div>
                </article>
            @endforeach
        </div>
        <div class="mt-10">{{ $projects->withQueryString()->links() }}</div>
    </div>
</section>
@endsection
