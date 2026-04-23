@extends('layouts.app')

@section('content')
    @php
        $gallery = collect($page['media']['gallery'] ?? []);
        $secondaryImages = $gallery->slice(1, 3);
        $projectsUi = trans('brand.ui.projects');
    @endphp

    <section class="inner-hero portfolio-page-hero">
        <div class="container case-study-hero-layout">
            <div>
                <span class="eyebrow">{{ $page['label'] }}</span>
                <h1 class="page-title">{{ $page['title'] }}</h1>
                <p class="page-copy">{{ $page['summary'] }}</p>
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
                    <span class="eyebrow">{{ __('brand.common.context') }}</span>
                    <h2>{{ $projectsUi['context_title'] }}</h2>
                    <p>{{ $page['note'] }}</p>

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

                    <div class="case-meta-grid">
                        <div>
                            <strong>{{ __('brand.common.problem') }}</strong>
                            <p>{{ $page['challenge'] }}</p>
                        </div>
                        <div>
                            <strong>{{ __('brand.common.solution') }}</strong>
                            <p>{{ $page['solution'] }}</p>
                        </div>
                    </div>

                    <div class="case-study-actions">
                        <a href="{{ route('contact.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">{{ $projectsUi['discuss_similar'] }}</a>
                        <p>{{ $page['outcome'] }}</p>
                    </div>
                </article>

                <article class="panel case-study-metrics-card">
                    <span class="eyebrow">{{ __('brand.common.outcome') }}</span>
                    <h2>{{ $page['outcome'] }}</h2>
                    <div class="case-metric-row stacked">
                        @foreach($page['metrics'] as $metric)
                            <div class="case-metric-card">
                                <strong>{{ $metric['value'] }}</strong>
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

    @if($secondaryImages->isNotEmpty())
        <section class="section section-soft">
            <div class="container">
                <x-site.section-heading
                    eyebrow="Visual proof"
                    title="Screens, brand assets, and supporting visuals"
                    copy="These images make the project feel more concrete by showing the brand system, UI surface, and how the product is framed in-market."
                />

                <div class="case-gallery-grid">
                    @foreach($secondaryImages as $image)
                        <figure class="panel case-gallery-card" data-reveal>
                            <img src="{{ $image['src'] }}" alt="{{ $image['alt'] }}" loading="lazy">
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section">
        <div class="container narrow">
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
