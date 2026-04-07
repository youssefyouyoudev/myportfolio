@extends('layouts.app')

@section('content')
    <section class="inner-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ $page['label'] }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['summary'] }}</p>
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
                <h2>{{ __('brand.common.stack') }}</h2>
                <div class="stack-list">
                    @foreach($page['stack'] as $item)
                        <span>{{ $item }}</span>
                    @endforeach
                </div>
                <h3>{{ __('brand.common.features') }}</h3>
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
        </div>
    </section>
@endsection
