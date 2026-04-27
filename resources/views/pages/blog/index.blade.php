@extends('layouts.app')

@section('content')
    @php($site = \App\Support\BrandContent::site(app()->getLocale()))

    <section class="inner-hero">
        <div class="container narrow">
            <x-breadcrumb :items="$seo['breadcrumbs'] ?? []" />
            <span class="eyebrow">{{ $page['eyebrow'] }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['copy'] }}</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="card-grid two">
                @foreach($page['items'] as $article)
                    <article class="panel article-card">
                        <span>{{ $article['published_at'] }} · {{ $article['reading_time'] }} min read</span>
                        <h2>{{ $article['title'] }}</h2>
                        <p>{{ $article['excerpt'] }}</p>
                        <a href="{{ route('blog.show', ['locale' => app()->getLocale(), 'slug' => $article['slug']]) }}" class="btn btn-secondary">{{ $site['actions']['read_article'] }}</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
