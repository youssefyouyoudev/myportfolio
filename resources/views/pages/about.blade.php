@extends('layouts.app')

@section('content')
    @php
        $site = \App\Support\BrandContent::site(app()->getLocale());
        $aboutUi = trans('brand.ui.about');
    @endphp

    <section class="inner-hero">
        <div class="container">
            <x-breadcrumb :items="$seo['breadcrumbs'] ?? []" />
            <div class="about-hero-grid">
                <div>
                    <span class="eyebrow">{{ $page['eyebrow'] }}</span>
                    <h1 class="page-title">{{ $page['title'] }}</h1>
                    <p class="page-copy">{{ $page['intro'] }}</p>
                    <div class="hero-pills">
                        @foreach($aboutUi['pills'] as $pill)
                            <span>{{ $pill }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="panel about-photo-panel">
                    <img
                        src="{{ asset('images/youssef-youyou.jpg') }}"
                        alt="Youssef Youyou, senior full-stack developer based in Nador, Morocco"
                        width="720"
                        height="880"
                        loading="lazy"
                        class="about-photo"
                    >
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container split-layout">
            <div class="content-stack">
                @foreach($page['sections'] as $section)
                    <article class="panel prose-panel">
                        <h2>{{ $section['title'] }}</h2>
                        @foreach($section['paragraphs'] as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </article>
                @endforeach
            </div>

            <div class="content-stack">
                <article class="panel">
                    <h2>{{ $aboutUi['contribution_title'] }}</h2>
                    <ul class="simple-list">
                        @foreach($aboutUi['contribution_items'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </article>

                <article class="panel">
                    <h2>{{ $page['education']['title'] }}</h2>
                    <ul class="simple-list">
                        @foreach($page['education']['items'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </article>

                <article class="panel">
                    <h2>{{ $aboutUi['languages_title'] }}</h2>
                    <ul class="simple-list">
                        @foreach($site['language_levels'] as $language)
                            <li>{{ $language['name'] }} - {{ $language['level'] }}</li>
                        @endforeach
                    </ul>
                </article>
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container">
            <div class="card-grid three">
                @foreach($aboutUi['feature_cards'] as $card)
                    <article class="panel feature-card">
                        <h3>{{ $card['title'] }}</h3>
                        <p>{{ $card['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section final-cta">
        <div class="container">
            <div class="section-cta">
                <div>
                    <span class="eyebrow">{{ $aboutUi['cta']['eyebrow'] }}</span>
                    <h2>{{ $aboutUi['cta']['title'] }}</h2>
                    <p>{{ $aboutUi['cta']['copy'] }}</p>
                </div>
                <div class="cta-actions">
                    <a href="{{ route('contact.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">{{ $site['actions']['contact_me'] }}</a>
                    <a href="{{ route('availability', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">{{ $aboutUi['cta']['secondary'] }}</a>
                </div>
            </div>
        </div>
    </section>
@endsection
