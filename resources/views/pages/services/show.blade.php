@extends('layouts.app')

@section('content')
    @php($servicesUi = trans('brand.ui.services'))

    <section class="inner-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ __('brand.common.service') }}</span>
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
                <h2>{{ __('brand.common.who_it_helps') }}</h2>
                <p>{{ $page['who'] }}</p>
            </article>
            <article class="panel">
                <h2>{{ __('brand.common.business_value') }}</h2>
                <p>{{ $page['business_value'] }}</p>
            </article>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container split-layout">
            <article class="panel">
                <h2>{{ __('brand.common.what_is_included') }}</h2>
                <ul class="simple-list">
                    @foreach($page['deliverables'] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </article>
            <article class="panel">
                <h2>{{ __('brand.common.stack') }}</h2>
                <div class="stack-list">
                    @foreach($page['stack'] as $item)
                        <span>{{ $item }}</span>
                    @endforeach
                </div>
            </article>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <x-site.section-heading :eyebrow="__('brand.common.process')" :title="__('brand.common.how_the_work_moves')" :copy="$servicesUi['show_process_copy']" />
            <div class="process-grid">
                @foreach($page['process'] as $index => $item)
                    <article class="panel process-card" data-reveal>
                        <span class="process-step">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                        <h3>{{ $item }}</h3>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container">
            <x-site.section-heading :eyebrow="$servicesUi['show_faq_eyebrow']" :title="$servicesUi['show_faq_title']" />
            <div class="faq-list">
                @foreach($servicesUi['show_faqs'] as $faq)
                    <details class="panel faq-item" data-reveal>
                        <summary>{{ $faq['question'] }}</summary>
                        <p>{{ $faq['answer'] }}</p>
                    </details>
                @endforeach
            </div>
            <div class="section-cta">
                <div>
                    <span class="eyebrow">{{ $servicesUi['show_need_eyebrow'] }}</span>
                    <h2>{{ $page['title'] }}</h2>
                    <p>{{ $page['business_value'] }}</p>
                </div>
                <div class="cta-actions">
                    <a href="{{ route('contact.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">{{ __('brand.site.actions.contact_me') }}</a>
                    <a href="{{ route('services.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">{{ __('brand.site.actions.view_services') }}</a>
                </div>
            </div>
        </div>
    </section>
@endsection
