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
        <div class="container split-layout">
            <div class="content-stack">
                <article class="panel">
                    <h2>{{ $page['direct_title'] }}</h2>
                    <div class="contact-direct">
                        <a href="{{ $site['email_link'] }}">{{ $site['email'] }}</a>
                        <a href="{{ $site['phone_link'] }}">{{ $site['phone'] }}</a>
                        <a href="{{ $site['whatsapp_url'] }}" target="_blank" rel="noopener">WhatsApp</a>
                        <a href="{{ $site['linkedin_url'] }}" target="_blank" rel="noopener">LinkedIn</a>
                        <a href="{{ $site['github_url'] }}" target="_blank" rel="noopener">GitHub</a>
                        <span>{{ $site['location'] }}</span>
                    </div>
                </article>

                <article class="panel">
                    <h2>{{ $page['form_title'] }}</h2>
                    <ul class="simple-list">
                        @foreach($page['form_help'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </article>
            </div>

            <div>
                @if(session('status'))
                    <div class="status-banner">{{ session('status') }}</div>
                @endif
                <x-site.contact-form />
            </div>
        </div>
    </section>
@endsection
