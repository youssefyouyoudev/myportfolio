@extends('layouts.admin')

@section('content')
<h1 class="mb-4 text-2xl font-semibold text-[var(--text-strong)]">{{ $service->exists ? 'Edit service' : 'New service' }}</h1>
<form method="post" action="{{ $service->exists ? route('admin.services.update', [app()->getLocale(), $service]) : route('admin.services.store', app()->getLocale()) }}" class="surface space-y-4 p-6">
    @csrf
    @if($service->exists)
        @method('PUT')
    @endif
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Title</label>
            <input name="title" value="{{ old('title', $service->title) }}" class="input-ghost mt-2 w-full" required>
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Slug</label>
            <input name="slug" value="{{ old('slug', $service->slug) }}" class="input-ghost mt-2 w-full" required>
        </div>
    </div>
    <div>
        <label class="text-sm font-semibold text-[var(--muted)]">Excerpt</label>
        <input name="excerpt" value="{{ old('excerpt', $service->excerpt) }}" class="input-ghost mt-2 w-full">
    </div>
    <div>
        <label class="text-sm font-semibold text-[var(--muted)]">Body</label>
        <textarea name="body" rows="5" class="input-ghost mt-2 w-full">{{ old('body', $service->body) }}</textarea>
    </div>
    <div class="grid gap-4 md:grid-cols-3">
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Status</label>
            <select name="status" class="input-ghost mt-2 w-full">
                <option value="draft" @selected(old('status', $service->status) === 'draft')>Draft</option>
                <option value="published" @selected(old('status', $service->status) === 'published')>Published</option>
            </select>
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Category</label>
            <select name="category_id" class="input-ghost mt-2 w-full">
                <option value="">—</option>
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}" @selected(old('category_id', $service->category_id) == $id)>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Position</label>
            <input name="position" type="number" value="{{ old('position', $service->position) }}" class="input-ghost mt-2 w-full">
        </div>
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Price from</label>
            <input name="price_from" type="number" step="0.01" value="{{ old('price_from', $service->price_from) }}" class="input-ghost mt-2 w-full">
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">CTA URL</label>
            <input name="cta_url" value="{{ old('cta_url', $service->cta_url) }}" class="input-ghost mt-2 w-full">
        </div>
    </div>
    <div>
        <label class="text-sm font-semibold text-[var(--muted)]">Features (one per line)</label>
        <textarea name="features[]" rows="3" class="input-ghost mt-2 w-full">{{ implode("\n", old('features', $service->features ?? [])) }}</textarea>
    </div>
    <div>
        <label class="text-sm font-semibold text-[var(--muted)]">Tags</label>
        <select name="tag_ids[]" multiple class="input-ghost mt-2 w-full">
            @foreach($tags as $id => $name)
                <option value="{{ $id }}" @selected(collect(old('tag_ids', $service->tags->pluck('id')->all()))->contains($id))>{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn-primary" type="submit">Save</button>
</form>
@endsection
