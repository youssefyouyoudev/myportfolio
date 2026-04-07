@extends('layouts.app')

@section('content')
    @php($site = \App\Support\BrandContent::site(app()->getLocale()))

    <section class="inner-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ $page['eyebrow'] }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['copy'] }}</p>
            <div class="hero-pills">
                <span>Business systems</span>
                <span>SaaS and platform delivery</span>
                <span>Architecture to deployment</span>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="card-grid three">
                @foreach($page['items'] as $service)
                    <article class="panel service-detail-card">
                        <h2>{{ $service['title'] }}</h2>
                        <p>{{ $service['summary'] }}</p>
                        <p><strong>{{ $service['business_value'] }}</strong></p>
                        <div class="stack-list">
                            @foreach($service['stack'] as $item)
                                <span>{{ $item }}</span>
                            @endforeach
                        </div>
                        <a href="{{ route('services.show', ['locale' => app()->getLocale(), 'service' => $service['slug']]) }}" class="btn btn-secondary">{{ $site['actions']['view_case_study'] }}</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container">
            <article class="panel matrix-card">
                <h2>How the services are typically used</h2>
                <div class="matrix-table">
                    <div class="matrix-row matrix-head">
                        <span>Service type</span>
                        <span>Best for</span>
                        <span>What it unlocks</span>
                    </div>
                    @foreach($page['items'] as $service)
                        <div class="matrix-row">
                            <strong>{{ $service['title'] }}</strong>
                            <span>{{ $service['who'] }}</span>
                            <span>{{ $service['business_value'] }}</span>
                        </div>
                    @endforeach
                </div>
            </article>
        </div>
    </section>
@endsection
