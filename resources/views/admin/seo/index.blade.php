@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between gap-3">
    <h1 class="text-2xl font-semibold text-[var(--text-strong)]">SEO Meta</h1>
    <a class="btn-primary text-sm" href="{{ route('admin.seo-meta.create', app()->getLocale()) }}">New</a>
</div>
<div class="surface overflow-hidden">
    <table class="admin-table text-sm">
        <thead>
            <tr>
                <th class="text-left">Title</th>
                <th class="text-left">Locale</th>
                <th class="text-left">Type</th>
                <th class="text-left"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($metas as $meta)
                <tr>
                    <td>{{ $meta->meta_title }}</td>
                    <td>{{ $meta->locale }}</td>
                    <td>{{ $meta->og_type }}</td>
                    <td class="space-x-3 text-right">
                        <a class="font-semibold text-[var(--accent-2)] hover:opacity-80" href="{{ route('admin.seo-meta.edit', [app()->getLocale(), $meta]) }}">Edit</a>
                        <form method="post" action="{{ route('admin.seo-meta.destroy', [app()->getLocale(), $meta]) }}" class="inline">
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
<div class="mt-4 text-sm text-[var(--muted)]">{{ $metas->links() }}</div>
@endsection
