@extends('layouts.app')

@section('content')
    @php
        $items = collect($page['items']);
        $featured = $items->take(3);
        $secondary = $items->slice(3);
    @endphp

    <section class="inner-hero portfolio-page-hero">
        <div class="container narrow">
            <x-breadcrumb :items="$seo['breadcrumbs'] ?? []" />
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
                            <x-site.project-frame :project="$project" />
                        </div>

                        <div class="case-study-copy">
                            <div class="case-study-meta-line">
                                <span class="eyebrow">{{ $project['label'] }}</span>
                                @if($project['is_nda'] ?? false)
                                    <span class="case-badge">Under NDA - details available on request</span>
                                @elseif($project['is_concept'] ?? false)
                                    <span class="case-badge">Concept / Portfolio piece</span>
                                @endif
                            </div>
                            <h2>{{ $project['title'] }}</h2>
                            <p class="case-summary">{{ $project['summary'] }}</p>
                            <p class="result-headline">{{ $project['result_headline'] ?? $project['outcome'] ?? 'A stronger product story with clearer business value.' }}</p>

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
                                @if(! empty($project['built_at']))
                                    <span>{{ $project['built_at'] }}</span>
                                @endif
                            </div>

                            <div class="case-metric-row">
                                @foreach($project['metrics'] as $metric)
                                    <div class="case-metric-card">
                                        <strong>{{ $metric['value'] }}</strong>
                                        <span>{{ $metric['label'] }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="case-study-actions">
                                <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'project' => $project['slug']]) }}" class="btn btn-primary">{{ __('brand.site.actions.view_case_study') }}</a>
                                @if(! empty($project['live_url']))
                                    <a href="{{ $project['live_url'] }}" class="btn btn-secondary" target="_blank" rel="noopener noreferrer">View Live -&gt;</a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="portfolio-secondary-grid">
                @foreach($secondary as $project)
                    <article class="panel secondary-case-card case-theme-{{ $project['media']['theme'] ?? 'default' }}" data-reveal>
                        <div class="secondary-case-visual">
                            <x-site.project-frame :project="$project" compact />
                        </div>
                        <div class="project-copy">
                            <div class="case-study-meta-line">
                                <span class="eyebrow">{{ $project['label'] }}</span>
                                @if($project['is_nda'] ?? false)
                                    <span class="case-badge">Under NDA - details available on request</span>
                                @elseif($project['is_concept'] ?? false)
                                    <span class="case-badge">Concept / Portfolio piece</span>
                                @endif
                            </div>
                            <h3>{{ $project['title'] }}</h3>
                            <p>{{ $project['summary'] }}</p>
                            <div class="stack-list">
                                @foreach($project['stack'] as $item)
                                    <span>{{ $item }}</span>
                                @endforeach
                                @if(! empty($project['built_at']))
                                    <span>{{ $project['built_at'] }}</span>
                                @endif
                            </div>
                            <p><strong>{{ __('brand.common.built_for') }}:</strong> {{ $project['audience'] }}</p>
                            <p><strong>{{ __('brand.common.outcome') }}:</strong> {{ $project['result_headline'] ?? $project['outcome'] ?? 'A clearer project story with stronger business value.' }}</p>
                            <div class="case-inline-actions">
                                <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'project' => $project['slug']]) }}" class="text-link">{{ __('brand.site.actions.view_case_study') }}</a>
                                @if(! empty($project['live_url']))
                                    <a href="{{ $project['live_url'] }}" class="text-link" target="_blank" rel="noopener noreferrer">View Live -&gt;</a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
