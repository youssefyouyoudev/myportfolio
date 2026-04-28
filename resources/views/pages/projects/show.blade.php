@extends('layouts.app')

@section('content')
    @php
        $gallery = collect($page['media']['gallery'] ?? []);
        $secondaryImages = ($page['is_nda'] ?? false) ? collect() : $gallery->slice(1, 3);
        $projectsUi = trans('brand.ui.projects');
    @endphp

    <section class="inner-hero portfolio-page-hero">
        <div class="container case-study-hero-layout">
            <div>
                <x-breadcrumb :items="$seo['breadcrumbs'] ?? []" />
                <a href="{{ route('projects.index', ['locale' => app()->getLocale()]) }}" class="text-link">&larr; Back to projects</a>
                <span class="eyebrow">{{ $page['label'] }}</span>
                <h1 class="page-title">{{ $page['title'] }}</h1>
                <p class="page-copy">{{ $page['summary'] }}</p>
                <div class="case-study-meta-line">
                    @if($page['is_nda'] ?? false)
                        <span class="case-badge">Under NDA - details available on request</span>
                    @elseif($page['is_concept'] ?? false)
                        <span class="case-badge">Concept / Portfolio piece</span>
                    @endif
                    @if(! empty($page['built_at']))
                        <span class="case-badge">{{ $page['built_at'] }}</span>
                    @endif
                </div>
                <div class="stack-list">
                    @foreach($page['stack'] as $item)
                        <span>{{ $item }}</span>
                    @endforeach
                </div>
            </div>

            <div class="case-study-hero-art case-theme-{{ $page['media']['theme'] ?? 'default' }}">
                <x-site.project-frame :project="$page" eager loading="eager" />
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="case-study-overview-grid">
                <article class="panel case-study-overview-card">
                    <span class="eyebrow">Context</span>
                    <h2>{{ $projectsUi['context_title'] }}</h2>
                    <p>{{ $page['context'] ?: $page['note'] }}</p>

                    <div class="case-meta-grid">
                        <div>
                            <strong>{{ __('brand.common.built_for') }}</strong>
                            <p>{{ $page['audience'] }}</p>
                        </div>
                        <div>
                            <strong>{{ __('brand.common.role') }}</strong>
                            <p>{{ $page['role'] }}</p>
                        </div>
                    </div>

                    <div class="case-study-actions">
                        <a href="{{ route('contact.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">{{ $projectsUi['discuss_similar'] }}</a>
                        @if(! empty($page['live_url']))
                            <a href="{{ $page['live_url'] }}" class="btn btn-secondary" target="_blank" rel="noopener noreferrer">View Live -&gt;</a>
                        @endif
                        <p>{{ $page['outcome'] }}</p>
                    </div>
                </article>

                <article class="panel case-study-metrics-card">
                    <span class="eyebrow">Results</span>
                    <h2>{{ $page['result_headline'] ?? $page['outcome'] ?? 'Clear delivery results' }}</h2>
                    <div class="case-metric-row stacked">
                        @foreach($page['metrics'] as $metric)
                            <div class="case-metric-card">
                                @if(in_array(strtolower(trim((string) $metric['value'])), ['planned per scope', 'measured after launch'], true))
                                    <span class="case-metric-value">{{ $metric['value'] }}</span>
                                @else
                                    <strong>{{ $metric['value'] }}</strong>
                                @endif
                                <span>{{ $metric['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                    <ul class="simple-list case-feature-list">
                        @foreach($page['features'] as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                </article>
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container content-stack">
            <article class="panel prose-panel">
                <span class="eyebrow">Problem</span>
                <h2>{{ __('brand.common.problem') }}</h2>
                <p>{{ $page['problem_long'] ?: $page['challenge'] }}</p>
            </article>
            <article class="panel prose-panel">
                <span class="eyebrow">Solution</span>
                <h2>{{ __('brand.common.solution') }}</h2>
                <p>{{ $page['solution_long'] ?: $page['solution'] }}</p>
            </article>
            <article class="panel prose-panel">
                <span class="eyebrow">Outcome</span>
                <h2>{{ __('brand.common.outcome') }}</h2>
                <p>{{ $page['outcome_long'] ?: $page['outcome'] }}</p>
            </article>
        </div>
    </section>

    @if($secondaryImages->isNotEmpty())
        <section class="section">
            <div class="container">
                <x-site.section-heading
                    eyebrow="Visual proof"
                    title="Screens, brand assets, and supporting visuals"
                    copy="These images make the project feel more concrete by showing the brand system, UI surface, and how the product is framed in-market."
                />

                <div class="case-gallery-grid">
                    @foreach($secondaryImages as $image)
                        <figure class="panel case-gallery-card" data-reveal>
                            <img src="{{ $image['src'] }}" alt="{{ $image['alt'] }}" loading="lazy" width="1600" height="900">
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section">
        <div class="container narrow">
            <a href="{{ route('projects.index', ['locale' => app()->getLocale()]) }}" class="text-link">&larr; Back to projects</a>
            <div class="case-nav">
                @if($previous)
                    <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'project' => $previous['slug']]) }}" class="panel case-nav-link">
                        <span>{{ $projectsUi['previous_case'] }}</span>
                        <strong>{{ $previous['title'] }}</strong>
                    </a>
                @endif
                @if($next)
                    <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'project' => $next['slug']]) }}" class="panel case-nav-link">
                        <span>{{ $projectsUi['next_case'] }}</span>
                        <strong>{{ $next['title'] }}</strong>
                    </a>
                @endif
            </div>
        </div>
    </section>
@endsection
