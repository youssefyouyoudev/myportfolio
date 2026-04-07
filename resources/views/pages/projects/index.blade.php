@extends('layouts.app')

@section('content')
    @php
        $labels = collect($page['items'])->pluck('label')->unique()->values();
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

            <div class="card-grid project-grid">
                @foreach($page['items'] as $project)
                    <article class="panel project-card">
                        <div class="project-preview preview-dashboard">
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
                            <p><strong>{{ __('brand.common.challenge') }}:</strong> {{ $project['challenge'] }}</p>
                            <p><strong>{{ __('brand.common.solution') }}:</strong> {{ $project['solution'] }}</p>
                            <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'project' => $project['slug']]) }}" class="btn btn-secondary">{{ __('brand.site.actions.view_case_study') }}</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
