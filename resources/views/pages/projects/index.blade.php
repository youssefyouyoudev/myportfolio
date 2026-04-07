@extends('layouts.app')

@section('content')
    @php($site = \App\Support\BrandContent::site(app()->getLocale()))

    <section class="inner-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ $page['eyebrow'] }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['copy'] }}</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="card-grid two">
                @foreach($page['items'] as $project)
                    <article class="panel case-study-card">
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
                        <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'project' => $project['slug']]) }}" class="btn btn-secondary">{{ $site['actions']['view_case_study'] }}</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
