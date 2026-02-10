@extends('layouts.app')

@section('content')
<section class="section">
    <div class="mx-auto max-w-4xl px-6 space-y-8">
        <div class="section-title">
            <span class="heading-accent">{{ __('sections.contact') }}</span>
            <h1 class="text-3xl font-semibold text-[var(--text-strong)]">{{ __('contact.title') }}</h1>
            <p class="text-lg text-[var(--muted)]">{{ __('contact.subtitle') }}</p>
            @if(session('status'))
                <div class="rounded-xl border border-[var(--accent)]/40 bg-[rgba(15,163,168,0.08)] px-4 py-3 text-sm text-[var(--text-strong)]">{{ session('status') }}</div>
            @endif
        </div>
        <form method="post" action="{{ route('contact.store') }}" class="grid gap-4 surface p-6">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm text-[var(--muted)]">{{ __('contact.name') }}</label>
                    <input name="name" value="{{ old('name') }}" required class="input-ghost mt-2 w-full" />
                    @error('name')<p class="text-xs text-[var(--accent)] mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm text-[var(--muted)]">{{ __('contact.email') }}</label>
                    <input name="email" type="email" value="{{ old('email') }}" required class="input-ghost mt-2 w-full" />
                    @error('email')<p class="text-xs text-[var(--accent)] mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm text-[var(--muted)]">{{ __('contact.company') }}</label>
                    <input name="company" value="{{ old('company') }}" class="input-ghost mt-2 w-full" />
                </div>
                <div>
                    <label class="text-sm text-[var(--muted)]">{{ __('contact.budget') }}</label>
                    <input name="budget" value="{{ old('budget') }}" class="input-ghost mt-2 w-full" />
                </div>
            </div>
            <div>
                <label class="text-sm text-[var(--muted)]">{{ __('contact.message') }}</label>
                <textarea name="message" rows="5" required class="input-ghost mt-2 w-full">{{ old('message') }}</textarea>
                @error('message')<p class="text-xs text-[var(--accent)] mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center justify-between">
                <p class="text-xs text-[var(--muted)]">{{ __('contact.note') }}</p>
                <button type="submit" class="btn-primary">
                    {{ __('cta.send_message') }}
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
