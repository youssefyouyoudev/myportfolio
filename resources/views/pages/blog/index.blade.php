@extends('layouts.app')

@section('content')
<section class="section">
    <div class="mx-auto max-w-5xl px-6">
        <div class="flex items-center justify-between">
            <div class="section-title">
                <span class="heading-accent">{{ __('sections.blog') }}</span>
                <h1 class="text-3xl font-semibold text-[var(--text-strong)]">{{ __('sections.blog') }}</h1>
                <p class="text-[var(--muted)]">{{ $posts->total() }} {{ __('labels.articles') }}</p>
            </div>
            <span class="chip">{{ $posts->total() }} {{ __('labels.posts') }}</span>
        </div>
        <div class="mt-8 space-y-6">
            @foreach($posts as $post)
                <article class="surface p-5" data-reveal>
                    <h2 class="text-xl font-semibold text-[var(--text-strong)]">{{ $post->localized('title') }}</h2>
                    <p class="mt-2 text-sm text-[var(--muted)]">{{ $post->localized('excerpt') }}</p>
                    <div class="mt-4 flex items-center justify-between text-sm text-[var(--muted)]">
                        <span>{{ $post->published_at?->translatedFormat('M d, Y') }}</span>
                        <a class="text-[var(--accent)] font-semibold" href="{{ route('blog.show', $post) }}">{{ __('cta.read') }}</a>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="mt-10">{{ $posts->withQueryString()->links() }}</div>
    </div>
</section>
@endsection
