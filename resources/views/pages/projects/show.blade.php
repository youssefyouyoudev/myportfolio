@extends('layouts.app')

@section('content')
    @php
        $projectsUi = trans('brand.ui.projects');
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
            <span class="eyebrow">{{ $page['label'] }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['summary'] }}</p>
            <div class="hero-pills">
                @foreach($page['stack'] as $item)
                    <span>{{ $item }}</span>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <article class="panel project-spotlight">
                <div class="spotlight-visual {{ $previewClasses[$page['slug']] ?? 'preview-dashboard' }}">
                    <div class="preview-surface">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="spotlight-copy">
                    <span class="eyebrow">{{ __('brand.common.context') }}</span>
                    <h2>{{ $projectsUi['context_title'] }}</h2>
                    <p>{{ $page['note'] }}</p>
                    <div class="spotlight-details">
                        <div>
                            <strong>{{ __('brand.common.challenge') }}</strong>
                            <p>{{ $page['challenge'] }}</p>
                        </div>
                        <div>
                            <strong>{{ __('brand.common.solution') }}</strong>
                            <p>{{ $page['solution'] }}</p>
                        </div>
                    </div>
                    <div class="project-footer">
                        <p>{{ $page['outcome'] }}</p>
                        <a href="{{ route('contact.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">{{ $projectsUi['discuss_similar'] }}</a>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container split-layout">
            <article class="panel">
                <h2>{{ __('brand.common.role') }}</h2>
                <p>{{ $page['role'] }}</p>
                <h3>{{ __('brand.common.outcome') }}</h3>
                <p>{{ $page['outcome'] }}</p>
            </article>
            <article class="panel">
                <h2>{{ __('brand.common.features') }}</h2>
                <ul class="simple-list">
                    @foreach($page['features'] as $feature)
                        <li>{{ $feature }}</li>
                    @endforeach
                </ul>
            </article>
        </div>
    </section>

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
