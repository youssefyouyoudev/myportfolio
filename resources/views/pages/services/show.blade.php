@extends('layouts.app')

@section('content')
    <section class="inner-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ __('brand.common.service') }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['summary'] }}</p>
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
            <x-site.section-heading :eyebrow="__('brand.common.process')" :title="__('brand.common.how_the_work_moves')" />
            <div class="card-grid four">
                @foreach($page['process'] as $index => $item)
                    <article class="panel process-card">
                        <span>{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                        <h3>{{ $item }}</h3>
                    </article>
                @endforeach
            </div>
            <x-site.section-cta :title="$page['title']" :copy="$page['business_value']" />
        </div>
    </section>
@endsection
