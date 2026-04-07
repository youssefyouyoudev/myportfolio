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

    @if(! empty($page['stats']))
        <section class="section">
            <div class="container">
                <div class="proof-grid">
                    @foreach($page['stats'] as $stat)
                        <article class="panel stat-card">
                            <strong>{{ $stat['value'] }}</strong>
                            <span>{{ $stat['label'] }}</span>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(! empty($page['cards']))
        <section class="section {{ empty($page['stats']) ? '' : 'section-soft' }}">
            <div class="container">
                <div class="card-grid three">
                    @foreach($page['cards'] as $card)
                        <article class="panel feature-card">
                            <h2>{{ $card['title'] }}</h2>
                            <p>{{ $card['copy'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(! empty($page['sections']))
        <section class="section">
            <div class="container content-stack">
                @foreach($page['sections'] as $section)
                    <article class="panel prose-panel">
                        <h2>{{ $section['title'] }}</h2>
                        @foreach($section['paragraphs'] ?? [] as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                        @if(! empty($section['list']))
                            <ul class="simple-list">
                                @foreach($section['list'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if(! empty($page['matrix']))
        <section class="section section-soft">
            <div class="container">
                <article class="panel matrix-card">
                    <h2>{{ $page['matrix']['title'] }}</h2>
                    <div class="matrix-table">
                        <div class="matrix-row matrix-head">
                            <span></span>
                            @foreach($page['matrix']['columns'] as $column)
                                <span>{{ $column }}</span>
                            @endforeach
                        </div>
                        @foreach($page['matrix']['rows'] as $row)
                            <div class="matrix-row">
                                <strong>{{ $row['label'] }}</strong>
                                @foreach($row['cells'] as $cell)
                                    <span>{{ $cell }}</span>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </article>
            </div>
        </section>
    @endif

    @if(! empty($page['placeholders']))
        <section class="section">
            <div class="container narrow">
                <article class="panel prose-panel">
                    <h2>Placeholders for Real Proof</h2>
                    <ul class="simple-list">
                        @foreach($page['placeholders'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </article>
            </div>
        </section>
    @endif

    @if(! empty($page['faq']))
        <section class="section {{ empty($page['placeholders']) ? 'section-soft' : '' }}">
            <div class="container">
                <div class="faq-list">
                    @foreach($page['faq'] as $item)
                        <details class="panel faq-item">
                            <summary>{{ $item['question'] }}</summary>
                            <p>{{ $item['answer'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(! empty($page['cta']))
        <section class="section final-cta">
            <div class="container">
                <div class="section-cta">
                    <div>
                        <span class="eyebrow">Next Step</span>
                        <h2>{{ $page['cta']['title'] }}</h2>
                        <p>{{ $page['cta']['copy'] }}</p>
                    </div>
                    <div class="cta-actions">
                        <a href="{{ route('contact.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">{{ $site['actions']['contact_me'] }}</a>
                        <a href="{{ $site['whatsapp_url'] }}" class="btn btn-secondary" target="_blank" rel="noopener">WhatsApp</a>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
