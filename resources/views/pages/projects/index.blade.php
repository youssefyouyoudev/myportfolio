@extends('layouts.app')

@section('content')
    @php
        $labels = collect($page['items'])->pluck('label')->unique()->values();
        $featured = collect($page['items'])->first();
        $rest = collect($page['items'])->slice(1)->values();
        $previewClasses = [
            'syncflow-social' => 'preview-saas',
            'secure-auth-suite' => 'preview-school',
            'business-management-platform' => 'preview-dashboard',
            'automation-dashboard-suite' => 'preview-api',
            'react-frontend-performance' => 'preview-mobile',
        ];
    @endphp

    <section class="inner-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ $page['eyebrow'] }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['copy'] }}</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="hero-pills">
                @foreach($labels as $label)
                    <span>{{ $label }}</span>
                @endforeach
            </div>

            @if($featured)
                <article class="panel project-spotlight" data-reveal>
                    <div class="spotlight-visual {{ $previewClasses[$featured['slug']] ?? 'preview-dashboard' }}">
                        <div class="preview-surface">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="spotlight-copy">
                        <span class="eyebrow">{{ $featured['label'] }}</span>
                        <h2>{{ $featured['title'] }}</h2>
                        <p>{{ $featured['summary'] }}</p>
                        <div class="stack-list">
                            @foreach($featured['stack'] as $item)
                                <span>{{ $item }}</span>
                            @endforeach
                        </div>
                        <div class="spotlight-details">
                            <div>
                                <strong>{{ __('brand.common.built_for') }}</strong>
                                <p>{{ $featured['client'] ?? $featured['note'] }}</p>
                            </div>
                            <div>
                                <strong>{{ __('brand.common.role') }}</strong>
                                <p>{{ $featured['role'] }}</p>
                            </div>
                            <div>
                                <strong>{{ __('brand.common.outcome') }}</strong>
                                <p>{{ $featured['outcome'] }}</p>
                            </div>
                        </div>
                        <div class="spotlight-details">
                            <div>
                                <strong>{{ __('brand.common.challenge') }}</strong>
                                <p>{{ $featured['challenge'] }}</p>
                            </div>
                            <div>
                                <strong>{{ __('brand.common.solution') }}</strong>
                                <p>{{ $featured['solution'] }}</p>
                            </div>
                        </div>
                        <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'project' => $featured['slug']]) }}" class="btn btn-primary">{{ __('brand.site.actions.view_case_study') }}</a>
                    </div>
                </article>
            @endif

            <div class="card-grid project-grid compact-project-grid">
                @foreach($rest as $project)
                    <article class="panel project-card" data-reveal>
                        <div class="project-preview {{ $previewClasses[$project['slug']] ?? 'preview-dashboard' }}">
                            <div class="preview-surface">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                        <div class="project-copy">
                            <span class="eyebrow muted">{{ $project['label'] }}</span>
                            <h2>{{ $project['title'] }}</h2>
                            <p>{{ $project['summary'] }}</p>
                            <div class="stack-list">
                                @foreach($project['stack'] as $item)
                                    <span>{{ $item }}</span>
                                @endforeach
                            </div>
                            <p><strong>{{ __('brand.common.built_for') }}:</strong> {{ $project['client'] ?? $project['note'] }}</p>
                            <p><strong>{{ __('brand.common.challenge') }}:</strong> {{ $project['challenge'] }}</p>
                            <p><strong>{{ __('brand.common.solution') }}:</strong> {{ $project['solution'] }}</p>
                            <p><strong>{{ __('brand.common.outcome') }}:</strong> {{ $project['outcome'] }}</p>
                            <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'project' => $project['slug']]) }}" class="text-link">{{ __('brand.site.actions.view_case_study') }}</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
