@extends('layouts.app')

@section('content')
<section class="section">
    <div class="mx-auto max-w-5xl px-6 space-y-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div class="space-y-3">
                <p class="heading-accent">{{ __('sections.projects') }}</p>
                <h1 class="mt-1 text-3xl font-semibold text-[var(--text-strong)]">{{ $project->localized('title') }}</h1>
                <p class="text-lg text-[var(--muted)]">{{ $project->localized('excerpt') }}</p>
                <div class="mt-3 flex flex-wrap gap-2 text-xs text-[var(--muted)]">
                    @foreach(($project->stack ?? []) as $tech)
                        <span class="chip">{{ $tech }}</span>
                    @endforeach
                </div>
            </div>
            <div class="flex flex-col gap-3 text-sm text-[var(--text-strong)]">
                {{-- @if($project->live_url)
                    <a class="btn-ghost justify-center" href="{{ $project->live_url }}" target="_blank" rel="noopener">{{ __('cta.visit_live') }}</a>
                @endif --}}
                @if($project->repo_url)
                    <a class="btn-ghost justify-center" href="{{ $project->repo_url }}" target="_blank" rel="noopener">{{ __('labels.repo') }}</a>
                @endif
            </div>
        </div>

        <div class="surface p-6">
            <div class="prose max-w-none">
                {!! nl2br(e($project->localized('description'))) !!}
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-4">
            <a href="{{ route('contact.create') }}" class="btn-primary">
                {{ __('cta.hire_me') }}
            </a>
            @if($project->category)
                <span class="chip">{{ __('labels.category') }}: {{ $project->category->localized('name') }}</span>
            @endif
        </div>
    </div>
</section>
@endsection
