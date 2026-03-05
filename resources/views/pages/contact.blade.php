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

        {{-- Quick contact info --}}
        <div class="flex flex-wrap gap-4 text-sm text-[var(--muted)]">
            <a href="tel:+212610090070" class="flex items-center gap-2 surface px-4 py-3 rounded-xl hover:text-[var(--text-strong)] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--accent)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.68A2 2 0 012 .99h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.96a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" />
                </svg>
                <span>+212 610 090 070</span>
            </a>
            <a href="mailto:contact@youssefyouyou.com" class="flex items-center gap-2 surface px-4 py-3 rounded-xl hover:text-[var(--text-strong)] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--accent)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                    <polyline points="22,6 12,13 2,6" />
                </svg>
                <span>contact@youssefyouyou.com</span>
            </a>
            <a href="https://wa.me/212610090070" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 surface px-4 py-3 rounded-xl hover:text-[var(--text-strong)] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="#25d366">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                <span>WhatsApp</span>
            </a>
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
