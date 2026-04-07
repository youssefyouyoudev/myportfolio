@extends('layouts.app')

@section('content')
    @php($site = \App\Support\BrandContent::site(app()->getLocale()))

    <section class="inner-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ $page['eyebrow'] }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['copy'] }}</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="card-grid two">
                @foreach($page['items'] as $service)
                    <article class="panel service-detail-card">
                        <h2>{{ $service['title'] }}</h2>
                        <p>{{ $service['summary'] }}</p>
                        <p><strong>{{ $service['business_value'] }}</strong></p>
                        <div class="stack-list">
                            @foreach($service['stack'] as $item)
                                <span>{{ $item }}</span>
                            @endforeach
                        </div>
                        <a href="{{ route('services.show', ['locale' => app()->getLocale(), 'service' => $service['slug']]) }}" class="btn btn-secondary">{{ $site['actions']['view_case_study'] }}</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
