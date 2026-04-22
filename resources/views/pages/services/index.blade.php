@extends('layouts.app')

@section('content')
    @php
        $site = \App\Support\BrandContent::site(app()->getLocale());
        $servicesUi = trans('brand.ui.services');
    @endphp

    <section class="inner-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ $page['eyebrow'] }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['copy'] }}</p>
            <div class="hero-pills">
                @foreach($servicesUi['index_pills'] as $pill)
                    <span>{{ $pill }}</span>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="card-grid three">
                @foreach($page['items'] as $service)
                    <article class="panel service-detail-card" data-reveal>
                        <span class="eyebrow">{{ __('brand.common.service') }}</span>
                        <h2>{{ $service['title'] }}</h2>
                        <p>{{ $service['summary'] }}</p>
                        <p><strong>{{ $service['business_value'] }}</strong></p>
                        <div class="stack-list">
                            @foreach($service['stack'] as $item)
                                <span>{{ $item }}</span>
                            @endforeach
                        </div>
                        <a href="{{ route('services.show', ['locale' => app()->getLocale(), 'service' => $service['slug']]) }}" class="btn btn-secondary">{{ $site['actions']['view_service'] }}</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container">
            <article class="panel matrix-card">
                <h2>{{ $servicesUi['index_matrix_title'] }}</h2>
                <div class="matrix-table">
                    <div class="matrix-row matrix-head">
                        @foreach($servicesUi['index_matrix_columns'] as $column)
                            <span>{{ $column }}</span>
                        @endforeach
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

    <section class="section final-cta">
        <div class="container">
            <div class="section-cta">
                <div>
                    <span class="eyebrow">{{ $servicesUi['index_cta']['eyebrow'] }}</span>
                    <h2>{{ $servicesUi['index_cta']['title'] }}</h2>
                    <p>{{ $servicesUi['index_cta']['copy'] }}</p>
                </div>
                <div class="cta-actions">
                    <a href="{{ route('contact.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">{{ $site['actions']['contact_me'] }}</a>
                    <a href="{{ $site['whatsapp_url'] }}" class="btn btn-secondary" target="_blank" rel="noopener">{{ $site['actions']['whatsapp'] }}</a>
                </div>
            </div>
        </div>
    </section>
@endsection
