@extends('layouts.app')

@section('content')
    <section class="inner-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ $page['eyebrow'] }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['copy'] }}</p>
        </div>
    </section>

    <section class="section">
        <div class="container timeline">
            @foreach($page['timeline'] as $entry)
                <article class="timeline-item panel">
                    <div class="timeline-meta">
                        <span>{{ $entry['period'] }}</span>
                        <strong>{{ $entry['type'] }}</strong>
                    </div>
                    <h2>{{ $entry['title'] }} | {{ $entry['company'] }}</h2>
                    <p>{{ $entry['location'] }}</p>
                    <ul class="simple-list">
                        @foreach($entry['bullets'] as $bullet)
                            <li>{{ $bullet }}</li>
                        @endforeach
                    </ul>
                </article>
            @endforeach
        </div>
    </section>
@endsection
