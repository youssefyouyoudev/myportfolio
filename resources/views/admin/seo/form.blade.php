@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-semibold text-[var(--text-strong)] mb-4">{{ $meta->exists ? 'Edit SEO' : 'New SEO' }}</h1>
<form method="post" action="{{ $meta->exists ? route('admin.seo-meta.update', [app()->getLocale(), $meta]) : route('admin.seo-meta.store', app()->getLocale()) }}" class="surface p-6 space-y-4">
    @csrf
    @if($meta->exists)
        @method('PUT')
    @endif
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="text-sm text-[var(--muted)]">Meta title</label>
            <input name="meta_title" value="{{ old('meta_title', $meta->meta_title) }}" class="input-ghost mt-2 w-full" required>
        </div>
        <div>
            <label class="text-sm text-[var(--muted)]">Locale</label>
            <select name="locale" class="input-ghost mt-2 w-full">
                @foreach(['en','fr','ar'] as $locale)
                    <option value="{{ $locale }}" @selected(old('locale', $meta->locale) === $locale)>{{ strtoupper($locale) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div>
        <label class="text-sm text-[var(--muted)]">Meta description</label>
        <textarea name="meta_description" rows="3" class="input-ghost mt-2 w-full">{{ old('meta_description', $meta->meta_description) }}</textarea>
    </div>
    <div>
        <label class="text-sm text-[var(--muted)]">Meta image URL</label>
        <input name="meta_image" value="{{ old('meta_image', $meta->meta_image) }}" class="input-ghost mt-2 w-full">
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="text-sm text-[var(--muted)]">OG type</label>
            <input name="og_type" value="{{ old('og_type', $meta->og_type) }}" class="input-ghost mt-2 w-full">
        </div>
        <div>
            <label class="text-sm text-[var(--muted)]">Schema (JSON)</label>
            <textarea name="schema" rows="3" class="input-ghost mt-2 w-full">{{ old('schema', $meta->schema) }}</textarea>
        </div>
    </div>
    <button class="btn-primary" type="submit">Save</button>
</form>
@endsection
