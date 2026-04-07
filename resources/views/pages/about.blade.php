@extends('layouts.app')

@section('content')
    @php($site = \App\Support\BrandContent::site(app()->getLocale()))

    <section class="inner-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ $page['eyebrow'] }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['intro'] }}</p>
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
                    <h2>{{ $page['education']['title'] }}</h2>
                    <ul class="simple-list">
                        @foreach($page['education']['items'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </article>

                <article class="panel">
                    <h2>{{ $site['footer']['languages'] }}</h2>
                    <ul class="simple-list">
                        @foreach($site['language_levels'] as $language)
                            <li>{{ $language['name'] }} — {{ $language['level'] }}</li>
                        @endforeach
                    </ul>
                </article>
            </div>
        </div>
    </section>
@endsection
