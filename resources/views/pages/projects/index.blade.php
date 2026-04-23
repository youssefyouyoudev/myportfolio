@extends('layouts.app')

@section('content')
    @php
        $items = collect($page['items']);
        $featured = $items->take(3);
        $secondary = $items->slice(3);
    @endphp

    <section class="inner-hero portfolio-page-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ $page['eyebrow'] }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['copy'] }}</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="case-study-stack">
                @foreach($featured as $project)
                    <article class="panel case-study-block case-theme-{{ $project['media']['theme'] ?? 'default' }}" data-reveal>
                        <div class="case-study-media">
                            <div class="case-study-frame">
                                @if(isset($project['media']['logo']['src']))
                                    <div class="case-study-logo-surface">
                                        <img src="{{ $project['media']['logo']['src'] }}" alt="{{ $project['media']['logo']['alt'] }}" loading="lazy">
                                    </div>
                                @endif

                                @if(isset($project['media']['cover']['src']))
                                    <div class="case-study-image">
                                        <img src="{{ $project['media']['cover']['src'] }}" alt="{{ $project['media']['cover']['alt'] }}" loading="lazy">
                                    </div>
                                @else
                                    <div class="case-study-placeholder case-study-placeholder-{{ $project['media']['theme'] ?? 'default' }}">
                                        <div class="placeholder-window">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <div class="placeholder-chart">
                                            <i></i><i></i><i></i><i></i>
                                        </div>
                                        <div class="placeholder-list">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="case-study-copy">
                            <span class="eyebrow">{{ $project['label'] }}</span>
                            <h2>{{ $project['title'] }}</h2>
                            <p class="case-summary">{{ $project['summary'] }}</p>

                            <div class="case-meta-grid">
                                <div>
                                    <strong>{{ __('brand.common.problem') }}</strong>
                                    <p>{{ $project['challenge'] }}</p>
                                </div>
                                <div>
                                    <strong>{{ __('brand.common.solution') }}</strong>
                                    <p>{{ $project['solution'] }}</p>
                                </div>
                            </div>

                            <div class="stack-list">
                                @foreach($project['stack'] as $item)
                                    <span>{{ $item }}</span>
                                @endforeach
                            </div>

                            <div class="case-metric-row">
                                @foreach($project['metrics'] as $metric)
                                    <div class="case-metric-card">
                                        <strong>{{ $metric['value'] }}</strong>
                                        <span>{{ $metric['label'] }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'project' => $project['slug']]) }}" class="btn btn-primary">{{ __('brand.site.actions.view_case_study') }}</a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="portfolio-secondary-grid">
                @foreach($secondary as $project)
                    <article class="panel secondary-case-card case-theme-{{ $project['media']['theme'] ?? 'default' }}" data-reveal>
                        <div class="secondary-case-visual">
                            @if(isset($project['media']['cover']['src']))
                                <div class="case-study-image compact">
                                    <img src="{{ $project['media']['cover']['src'] }}" alt="{{ $project['media']['cover']['alt'] }}" loading="lazy">
                                </div>
                            @else
                                <div class="case-study-placeholder case-study-placeholder-{{ $project['media']['theme'] ?? 'default' }}">
                                    <div class="placeholder-window">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <div class="placeholder-table">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="project-copy">
                            <span class="eyebrow">{{ $project['label'] }}</span>
                            <h3>{{ $project['title'] }}</h3>
                            <p>{{ $project['summary'] }}</p>
                            <div class="stack-list">
                                @foreach($project['stack'] as $item)
                                    <span>{{ $item }}</span>
                                @endforeach
                            </div>
                            <p><strong>{{ __('brand.common.built_for') }}:</strong> {{ $project['audience'] }}</p>
                            <p><strong>{{ __('brand.common.outcome') }}:</strong> {{ $project['outcome'] }}</p>
                            <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'project' => $project['slug']]) }}" class="text-link">{{ __('brand.site.actions.view_case_study') }}</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
