@extends('layouts.app')

@section('content')
    @php($skillsUi = trans('brand.ui.skills'))

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
                    <article class="panel feature-card">
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
            <x-site.section-heading :eyebrow="$skillsUi['expertise_heading']" :title="$skillsUi['expertise_title']" :copy="$skillsUi['expertise_copy']" />
            <div class="card-grid three">
                @foreach($skillsUi['areas'] as $area)
                    <article class="panel feature-card">
                        <h3>{{ $area['title'] }}</h3>
                        <ul class="simple-list">
                            @foreach($area['items'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <x-site.section-heading :eyebrow="$skillsUi['working_style_eyebrow']" :title="$skillsUi['working_style_title']" />
            <div class="card-grid four">
                @foreach($page['strengths'] as $strength)
                    <article class="panel feature-card">
                        <h3>{{ $strength['title'] }}</h3>
                        <p>{{ $strength['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
