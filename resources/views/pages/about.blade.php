@extends('layouts.app')

@section('content')
    @php($site = \App\Support\BrandContent::site(app()->getLocale()))

    <section class="inner-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ $page['eyebrow'] }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['intro'] }}</p>
            <div class="hero-pills">
                <span>Senior Full-Stack Developer</span>
                <span>Systems Architect mindset</span>
                <span>Morocco and international-ready</span>
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
                    <h2>What I bring to a project</h2>
                    <ul class="simple-list">
                        <li>Strong backend and frontend coverage</li>
                        <li>Product thinking beyond code delivery</li>
                        <li>Scalable system design and architecture awareness</li>
                        <li>Deployment, infrastructure, and production readiness</li>
                        <li>Communication that works for clients, recruiters, and teams</li>
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
                    <h2>Languages and market readiness</h2>
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
                <article class="panel feature-card">
                    <h3>Technical philosophy</h3>
                    <p>Clean systems, clear architecture, maintainable code, and interfaces that feel intentional.</p>
                </article>
                <article class="panel feature-card">
                    <h3>Business mindset</h3>
                    <p>I think in workflows, outcomes, user friction, product direction, and operational value.</p>
                </article>
                <article class="panel feature-card">
                    <h3>Recruiter-friendly signal</h3>
                    <p>The site is structured to make seniority, range, and delivery quality visible quickly.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section final-cta">
        <div class="container">
            <div class="section-cta">
                <div>
                    <span class="eyebrow">Capabilities Deck Placeholder</span>
                    <h2>Add a polished PDF for agencies, recruiters, and serious leads.</h2>
                    <p>This is the right place to link a branded capabilities one-pager or recruiter-ready summary when you have the final version.</p>
                </div>
                <div class="cta-actions">
                    <a href="{{ route('contact.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">{{ $site['actions']['contact_me'] }}</a>
                    <a href="{{ route('availability', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">View Availability</a>
                </div>
            </div>
        </div>
    </section>
@endsection
