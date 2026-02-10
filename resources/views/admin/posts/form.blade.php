@extends('layouts.admin')

@section('content')
<h1 class="mb-4 text-2xl font-semibold text-[var(--text-strong)]">{{ $post->exists ? 'Edit post' : 'New post' }}</h1>
<form method="post" action="{{ $post->exists ? route('admin.posts.update', [app()->getLocale(), $post]) : route('admin.posts.store', app()->getLocale()) }}" class="surface space-y-4 p-6">
    @csrf
    @if($post->exists)
        @method('PUT')
    @endif
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Title</label>
            <input name="title" value="{{ old('title', $post->title) }}" class="input-ghost mt-2 w-full" required>
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Slug</label>
            <input name="slug" value="{{ old('slug', $post->slug) }}" class="input-ghost mt-2 w-full" required>
        </div>
    </div>
    <div>
        <label class="text-sm font-semibold text-[var(--muted)]">Excerpt</label>
        <input name="excerpt" value="{{ old('excerpt', $post->excerpt) }}" class="input-ghost mt-2 w-full">
    </div>
    <div>
        <label class="text-sm font-semibold text-[var(--muted)]">Body</label>
        <textarea name="body" rows="6" class="input-ghost mt-2 w-full">{{ old('body', $post->body) }}</textarea>
    </div>
    <div class="grid gap-4 md:grid-cols-3">
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Status</label>
            <select name="status" class="input-ghost mt-2 w-full">
                <option value="draft" @selected(old('status', $post->status) === 'draft')>Draft</option>
                <option value="published" @selected(old('status', $post->status) === 'published')>Published</option>
            </select>
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Category</label>
            <select name="category_id" class="input-ghost mt-2 w-full">
                <option value="">—</option>
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}" @selected(old('category_id', $post->category_id) == $id)>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Published at</label>
            <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}" class="input-ghost mt-2 w-full">
        </div>
    </div>
    <div>
        <label class="text-sm font-semibold text-[var(--muted)]">Tags</label>
        <select name="tag_ids[]" multiple class="input-ghost mt-2 w-full">
            @foreach($tags as $id => $name)
                <option value="{{ $id }}" @selected(collect(old('tag_ids', $post->tags->pluck('id')->all()))->contains($id))>{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn-primary" type="submit">Save</button>
</form>
@endsection
