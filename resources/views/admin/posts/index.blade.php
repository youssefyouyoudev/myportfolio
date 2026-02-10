@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between gap-3">
    <h1 class="text-2xl font-semibold text-[var(--text-strong)]">Posts</h1>
    <a class="btn-primary text-sm" href="{{ route('admin.posts.create', app()->getLocale()) }}">New post</a>
</div>
<div class="surface overflow-hidden">
    <table class="admin-table text-sm">
        <thead>
            <tr>
                <th class="text-left">Title</th>
                <th class="text-left">Status</th>
                <th class="text-left">Published</th>
                <th class="text-left"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->status }}</td>
                    <td class="text-[var(--muted)]">{{ optional($post->published_at)->format('Y-m-d') }}</td>
                    <td class="space-x-3 text-right">
                        <a class="font-semibold text-[var(--accent-2)] hover:opacity-80" href="{{ route('admin.posts.edit', [app()->getLocale(), $post]) }}">Edit</a>
                        <form method="post" action="{{ route('admin.posts.destroy', [app()->getLocale(), $post]) }}" class="inline">
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
<div class="mt-4 text-sm text-[var(--muted)]">{{ $posts->links() }}</div>
@endsection
