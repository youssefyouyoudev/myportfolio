@extends('layouts.app')

@section('content')
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
        <div class="container split-layout">
            <article class="panel">
                <h2>{{ __('brand.common.challenge') }}</h2>
                <p>{{ $page['challenge'] }}</p>
            </article>
            <article class="panel">
                <h2>{{ __('brand.common.solution') }}</h2>
                <p>{{ $page['solution'] }}</p>
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
            <article class="panel prose-panel">
                <h2>{{ __('brand.common.context') }}</h2>
                <p>{{ $page['note'] }}</p>
            </article>
            <div class="case-nav">
                @if($previous)
                    <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'project' => $previous['slug']]) }}" class="panel case-nav-link">
                        <span>Previous Case</span>
                        <strong>{{ $previous['title'] }}</strong>
                    </a>
                @endif
                @if($next)
                    <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'project' => $next['slug']]) }}" class="panel case-nav-link">
                        <span>Next Case</span>
                        <strong>{{ $next['title'] }}</strong>
                    </a>
                @endif
            </div>
        </div>
    </section>
@endsection
