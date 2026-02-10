@extends('layouts.app')

@section('content')
<section class="section">
    <div class="mx-auto max-w-4xl px-6 space-y-8">
        <div class="space-y-2">
            <p class="heading-accent">{{ __('sections.blog') }}</p>
            <h1 class="text-3xl font-semibold text-[var(--text-strong)]">{{ $post->localized('title') }}</h1>
            <p class="text-sm text-[var(--muted)]">{{ $post->published_at?->translatedFormat('M d, Y') }}</p>
        </div>
        <div class="surface p-6">
            <div class="prose max-w-none">
                {!! nl2br(e($post->localized('body'))) !!}
            </div>
        </div>
        <a class="inline-flex items-center gap-2 text-sm text-[var(--accent)] font-semibold" href="{{ route('blog.index') }}">← {{ __('cta.back_to_blog') }}</a>
    </div>
</section>
@endsection
