@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between gap-3">
    <h1 class="text-2xl font-semibold text-[var(--text-strong)]">Tags</h1>
    <a class="btn-primary text-sm" href="{{ route('admin.tags.create', app()->getLocale()) }}">New tag</a>
</div>
<div class="surface overflow-hidden">
    <table class="admin-table text-sm">
        <thead>
            <tr>
                <th class="text-left">Name</th>
                <th class="text-left">Type</th>
                <th class="text-left">Slug</th>
                <th class="text-left"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td>{{ $tag->name }}</td>
                    <td>{{ $tag->type }}</td>
                    <td>{{ $tag->slug }}</td>
                    <td class="space-x-3 text-right">
                        <a class="font-semibold text-[var(--accent-2)] hover:opacity-80" href="{{ route('admin.tags.edit', [app()->getLocale(), $tag]) }}">Edit</a>
                        <form method="post" action="{{ route('admin.tags.destroy', [app()->getLocale(), $tag]) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn-danger text-sm" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4 text-sm text-[var(--muted)]">{{ $tags->links() }}</div>
@endsection
