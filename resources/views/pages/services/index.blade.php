@extends('layouts.app')

@section('content')
<section class="section">
    <div class="mx-auto max-w-6xl px-6">
        <div class="flex items-center justify-between">
            <div class="section-title">
                <span class="heading-accent">{{ __('sections.services') }}</span>
                <h1 class="text-3xl font-semibold text-[var(--text-strong)]">{{ __('sections.services') }}</h1>
                <p class="text-[var(--muted)]">{{ $services->count() }} {{ __('labels.services') }}</p>
            </div>
            <span class="chip">{{ $services->count() }} {{ __('labels.ready') }}</span>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-2">
            @foreach($services as $service)
                <article class="surface p-6" data-reveal>
                    <h2 class="text-xl font-semibold text-[var(--text-strong)]">{{ $service->localized('title') }}</h2>
                    <p class="mt-3 text-sm text-[var(--muted)]">{{ $service->localized('excerpt') }}</p>
                    <div class="mt-4 flex flex-wrap gap-2 text-xs text-[var(--muted)]">
                        @foreach(($service->features ?? []) as $feature)
                            <span class="chip">{{ $feature }}</span>
                        @endforeach
                    </div>
                    <div class="mt-6 flex items-center justify-between text-sm">
                        <a class="text-[var(--accent)] font-semibold" href="{{ route('services.show', $service) }}">{{ __('cta.view_details') }}</a>
                        <span class="text-[var(--muted)]">{{ __('labels.starts_from') }} {{ $service->price_from ? '$'.number_format($service->price_from) : __('labels.custom_quote') }}</span>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
