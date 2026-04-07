@extends('layouts.app')

@section('content')
    @php($site = \App\Support\BrandContent::site(app()->getLocale()))

    <section class="inner-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ $page['title'] }}</span>
            <h1 class="page-title">{{ $page['headline'] }}</h1>
            <p class="page-copy">{{ $page['intro'] }}</p>
            <div class="hero-actions">
                <a href="{{ route('contact.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">{{ $site['actions']['contact_me'] }}</a>
                <a href="{{ route('services.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">{{ $site['actions']['view_services'] }}</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container split-layout">
            <article class="panel prose-panel">
                @foreach($page['copy'] as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </article>
            <article class="panel">
                <ul class="simple-list">
                    @foreach($page['points'] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </article>
        </div>
    </section>
@endsection
