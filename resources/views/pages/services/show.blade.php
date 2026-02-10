@extends('layouts.app')

@section('content')
<section class="section">
    <div class="mx-auto max-w-5xl px-6 space-y-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <p class="heading-accent">{{ __('sections.services') }}</p>
                <h1 class="mt-2 text-3xl font-semibold text-[var(--text-strong)]">{{ $service->localized('title') }}</h1>
                <p class="mt-4 text-lg text-[var(--muted)]">{{ $service->localized('excerpt') }}</p>
            </div>
            @if($service->price_from)
                <div class="surface p-4 text-sm text-[var(--text-strong)]">
                    {{ __('labels.starts_from') }} <span class="font-semibold">${{ number_format($service->price_from) }}</span>
                </div>
            @endif
        </div>

        <div class="surface p-6">
            <div class="prose max-w-none">
                {!! nl2br(e($service->localized('body'))) !!}
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            @foreach(($service->features ?? []) as $feature)
                <div class="surface p-4 text-sm text-[var(--text-strong)]">{{ $feature }}</div>
            @endforeach
        </div>

        <div class="flex flex-wrap items-center gap-4">
            <a href="{{ route('contact.create') }}" class="btn-primary">
                {{ __('cta.hire_me') }}
            </a>
            @if($service->cta_url)
                <a class="text-[var(--accent)] font-semibold" href="{{ $service->cta_url }}" target="_blank" rel="noopener">{{ __('cta.learn_more') }}</a>
            @endif
        </div>
    </div>
</section>
@endsection
