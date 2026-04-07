@extends('layouts.app')

@section('content')
    <section class="inner-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ __('brand.common.article') }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['excerpt'] }}</p>
        </div>
    </section>

    <section class="section">
        <div class="container narrow article-layout">
            @foreach($page['sections'] as $section)
                <article class="panel article-section">
                    <h2>{{ $section['title'] }}</h2>
                    @foreach($section['paragraphs'] as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </article>
            @endforeach
        </div>
    </section>
@endsection
