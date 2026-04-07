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
        <div class="container">
            <div class="card-grid three">
                @foreach($page['groups'] as $group)
                    <article class="panel">
                        <h2>{{ $group['title'] }}</h2>
                        <div class="stack-list">
                            @foreach($group['items'] as $item)
                                <span>{{ $item }}</span>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container">
            <div class="card-grid four">
                @foreach($page['strengths'] as $strength)
                    <article class="panel">
                        <h3>{{ $strength['title'] }}</h3>
                        <p>{{ $strength['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
