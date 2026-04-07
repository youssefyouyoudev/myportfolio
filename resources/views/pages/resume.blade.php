@extends('layouts.app')

@section('content')
    @php($site = \App\Support\BrandContent::site(app()->getLocale()))

    <section class="inner-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ $page['eyebrow'] }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['copy'] }}</p>
            <div class="hero-actions">
                <button type="button" class="btn btn-primary" data-print-resume>{{ $site['actions']['print_resume'] }}</button>
                <a href="{{ route('contact.create', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">{{ $site['actions']['contact_me'] }}</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container narrow resume-sheet">
            <article class="panel resume-panel">
                <h2>{{ $site['name'] }}</h2>
                <p>{{ $site['role'] }}</p>
                <p>{{ $page['summary'] }}</p>
            </article>

            <article class="panel resume-panel">
                <h2>{{ $page['experience']['title'] }}</h2>
                @foreach($page['experience']['timeline'] as $entry)
                    <div class="resume-entry">
                        <strong>{{ $entry['title'] }} | {{ $entry['company'] }}</strong>
                        <span>{{ $entry['period'] }} | {{ $entry['location'] }}</span>
                    </div>
                @endforeach
            </article>

            <article class="panel resume-panel">
                <h2>{{ $page['education_title'] }}</h2>
                <ul class="simple-list">
                    @foreach($page['education']['items'] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </article>

            <article class="panel resume-panel">
                <h2>{{ $page['skills']['title'] }}</h2>
                @foreach($page['skills']['groups'] as $group)
                    <div class="resume-entry">
                        <strong>{{ $group['title'] }}</strong>
                        <span>{{ implode(', ', $group['items']) }}</span>
                    </div>
                @endforeach
            </article>

            <article class="panel resume-panel">
                <h2>{{ $page['languages_title'] }}</h2>
                <ul class="simple-list">
                    @foreach($site['language_levels'] as $language)
                        <li>{{ $language['name'] }} - {{ $language['level'] }}</li>
                    @endforeach
                </ul>
            </article>
        </div>
    </section>
@endsection
