@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between gap-3">
    <h1 class="text-2xl font-semibold text-[var(--text-strong)]">Projects</h1>
    <a class="btn-primary text-sm" href="{{ route('admin.projects.create', app()->getLocale()) }}">New project</a>
</div>
<div class="surface overflow-hidden">
    <table class="admin-table text-sm">
        <thead>
            <tr>
                <th class="text-left">Title</th>
                <th class="text-left">Status</th>
                <th class="text-left">Featured</th>
                <th class="text-left">Published</th>
                <th class="text-left"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
                <tr>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->status }}</td>
                    <td>{{ $project->featured ? 'Yes' : 'No' }}</td>
                    <td class="text-[var(--muted)]">{{ optional($project->published_at)->format('Y-m-d') }}</td>
                    <td class="space-x-3 text-right">
                        <a class="font-semibold text-[var(--accent-2)] hover:opacity-80" href="{{ route('admin.projects.edit', [app()->getLocale(), $project]) }}">Edit</a>
                        <form method="post" action="{{ route('admin.projects.destroy', [app()->getLocale(), $project]) }}" class="inline">
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
<div class="mt-4 text-sm text-[var(--muted)]">{{ $projects->links() }}</div>
@endsection
