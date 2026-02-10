@extends('layouts.admin')

@section('content')
<h1 class="mb-4 text-2xl font-semibold text-[var(--text-strong)]">{{ $tag->exists ? 'Edit tag' : 'New tag' }}</h1>
<form method="post" action="{{ $tag->exists ? route('admin.tags.update', [app()->getLocale(), $tag]) : route('admin.tags.store', app()->getLocale()) }}" class="surface space-y-4 p-6">
    @csrf
    @if($tag->exists)
        @method('PUT')
    @endif
    <div class="grid gap-4 md:grid-cols-3">
        <div class="md:col-span-2">
            <label class="text-sm font-semibold text-[var(--muted)]">Name</label>
            <input name="name" value="{{ old('name', $tag->name) }}" class="input-ghost mt-2 w-full" required>
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Slug</label>
            <input name="slug" value="{{ old('slug', $tag->slug) }}" class="input-ghost mt-2 w-full" required>
        </div>
    </div>
    <div>
        <label class="text-sm font-semibold text-[var(--muted)]">Type</label>
        <select name="type" class="input-ghost mt-2 w-full">
            <option value="project" @selected(old('type', $tag->type) === 'project')>Project</option>
            <option value="post" @selected(old('type', $tag->type) === 'post')>Post</option>
            <option value="service" @selected(old('type', $tag->type) === 'service')>Service</option>
        </select>
    </div>
    <button class="btn-primary" type="submit">Save</button>
</form>
@endsection
