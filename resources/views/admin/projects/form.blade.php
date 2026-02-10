@extends('layouts.admin')

@section('content')
<h1 class="mb-4 text-2xl font-semibold text-[var(--text-strong)]">{{ $project->exists ? 'Edit project' : 'New project' }}</h1>
<form method="post" action="{{ $project->exists ? route('admin.projects.update', [app()->getLocale(), $project]) : route('admin.projects.store', app()->getLocale()) }}" class="surface space-y-4 p-6">
    @csrf
    @if($project->exists)
        @method('PUT')
    @endif
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Title</label>
            <input name="title" value="{{ old('title', $project->title) }}" class="input-ghost mt-2 w-full" required>
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Slug</label>
            <input name="slug" value="{{ old('slug', $project->slug) }}" class="input-ghost mt-2 w-full" required>
        </div>
    </div>
    <div>
        <label class="text-sm font-semibold text-[var(--muted)]">Excerpt</label>
        <input name="excerpt" value="{{ old('excerpt', $project->excerpt) }}" class="input-ghost mt-2 w-full">
    </div>
    <div>
        <label class="text-sm font-semibold text-[var(--muted)]">Description</label>
        <textarea name="description" rows="5" class="input-ghost mt-2 w-full">{{ old('description', $project->description) }}</textarea>
    </div>
    <div class="grid gap-4 md:grid-cols-3">
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Status</label>
            <select name="status" class="input-ghost mt-2 w-full">
                <option value="draft" @selected(old('status', $project->status) === 'draft')>Draft</option>
                <option value="published" @selected(old('status', $project->status) === 'published')>Published</option>
            </select>
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Category</label>
            <select name="category_id" class="input-ghost mt-2 w-full">
                <option value="">—</option>
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}" @selected(old('category_id', $project->category_id) == $id)>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-7 flex items-center gap-2 text-[var(--text)]">
            <input type="hidden" name="featured" value="0">
            <input type="checkbox" name="featured" value="1" class="h-4 w-4 accent-[var(--accent)]" @checked(old('featured', $project->featured))>
            <label class="text-sm font-semibold text-[var(--muted)]">Featured</label>
        </div>
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Live URL</label>
            <input name="live_url" value="{{ old('live_url', $project->live_url) }}" class="input-ghost mt-2 w-full">
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Repo URL</label>
            <input name="repo_url" value="{{ old('repo_url', $project->repo_url) }}" class="input-ghost mt-2 w-full">
        </div>
    </div>
    <div>
        <label class="text-sm font-semibold text-[var(--muted)]">Published at</label>
        <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($project->published_at)->format('Y-m-d\TH:i')) }}" class="input-ghost mt-2 w-full">
    </div>
    <div>
        <label class="text-sm font-semibold text-[var(--muted)]">Tags</label>
        <select name="tag_ids[]" multiple class="input-ghost mt-2 w-full">
            @foreach($tags as $id => $name)
                <option value="{{ $id }}" @selected(collect(old('tag_ids', $project->tags->pluck('id')->all()))->contains($id))>{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn-primary" type="submit">Save</button>
</form>
@endsection
