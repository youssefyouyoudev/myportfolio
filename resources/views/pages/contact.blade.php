@extends('layouts.app')

@section('content')
    @php
        $site = \App\Support\BrandContent::site(app()->getLocale());
        $contactUi = trans('brand.ui.contact');
        $directCards = collect($contactUi['direct_cards'] ?? [])->values()->map(function (array $card, int $index) use ($site): array {
            $value = match ($card['value']) {
                'email' => $site['email'],
                'phone' => $site['phone'],
                default => $card['value'],
            };

            $href = match ($index) {
                0 => $site['email_link'],
                1 => $site['whatsapp_url'],
                2 => $site['linkedin_url'],
                3 => $site['github_url'],
                default => '#',
            };

            return array_merge($card, ['value' => $value, 'href' => $href]);
        })->all();
    @endphp

    <section class="inner-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ $page['eyebrow'] }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['copy'] }}</p>
            <div class="hero-pills">
                @foreach($contactUi['pills'] as $pill)
                    <span>{{ $pill }}</span>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container contact-layout">
            <div class="contact-column">
                <div>
                    <h2>{{ $page['direct_title'] }}</h2>
                    <div class="contact-direct-grid">
                        @foreach($directCards as $card)
                            <a href="{{ $card['href'] }}" class="panel direct-link-card" @if(str_starts_with($card['href'], 'http')) target="_blank" rel="noopener" @endif>
                                <span>{{ $card['label'] }}</span>
                                <strong>{{ $card['value'] }}</strong>
                                <p>{{ $card['copy'] }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>

                <article class="panel">
                    <h2>{{ $page['form_title'] }}</h2>
                    <ul class="simple-list">
                        @foreach($page['form_help'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                        <li>{{ $contactUi['preferred_contact_method'] }}</li>
                    </ul>
                </article>

                <article class="panel">
                    <h2>{{ $contactUi['next_steps_title'] }}</h2>
                    <ul class="simple-list">
                        @foreach($contactUi['next_steps'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </article>
            </div>

            <div>
                @if(session('status'))
                    <div class="status-banner" role="status" aria-live="polite">{{ session('status') }}</div>
                @endif
                @if($errors->any())
                    <div class="status-banner status-banner-error" role="alert">
                        Please review the highlighted fields and try again.
                    </div>
                @endif
                <x-site.contact-form />
            </div>
        </div>
    </section>
@endsection
