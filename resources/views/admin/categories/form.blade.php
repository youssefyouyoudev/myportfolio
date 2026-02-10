@extends('layouts.admin')

@section('content')
<h1 class="mb-4 text-2xl font-semibold text-[var(--text-strong)]">{{ $category->exists ? 'Edit category' : 'New category' }}</h1>
<form method="post" action="{{ $category->exists ? route('admin.categories.update', [app()->getLocale(), $category]) : route('admin.categories.store', app()->getLocale()) }}" class="surface space-y-4 p-6">
    @csrf
    @if($category->exists)
        @method('PUT')
    @endif
    <div class="grid gap-4 md:grid-cols-3">
        <div class="md:col-span-2">
            <label class="text-sm font-semibold text-[var(--muted)]">Name</label>
            <input name="name" value="{{ old('name', $category->name) }}" class="input-ghost mt-2 w-full" required>
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Slug</label>
            <input name="slug" value="{{ old('slug', $category->slug) }}" class="input-ghost mt-2 w-full" required>
        </div>
    </div>
    <div>
        <label class="text-sm font-semibold text-[var(--muted)]">Type</label>
        <select name="type" class="input-ghost mt-2 w-full">
            <option value="project" @selected(old('type', $category->type) === 'project')>Project</option>
            <option value="post" @selected(old('type', $category->type) === 'post')>Post</option>
            <option value="service" @selected(old('type', $category->type) === 'service')>Service</option>
        </select>
    </div>
    <div>
        <label class="text-sm font-semibold text-[var(--muted)]">Description</label>
        <textarea name="description" rows="3" class="input-ghost mt-2 w-full">{{ old('description', $category->description) }}</textarea>
    </div>
    <button class="btn-primary" type="submit">Save</button>
</form>
@endsection
