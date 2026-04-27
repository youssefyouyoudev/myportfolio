@extends('layouts.admin')

@section('title', 'Projects')
@section('admin_title', 'Projects')
@section('admin_copy', 'Manage portfolio case studies, featured work, hero images, supporting screenshots, and SEO-ready project entries.')

@section('content')
    <div class="admin-toolbar">
        <div>
            <span class="eyebrow">Content module</span>
            <h2 class="section-title">Project library</h2>
            <p class="section-copy">Published entries can power the public case-study pages automatically while drafts stay private.</p>
        </div>
        <div class="admin-toolbar-actions">
            <a class="btn btn-primary btn-compact" href="{{ route('admin.projects.create', app()->getLocale()) }}">New project</a>
        </div>
    </div>

    <div class="surface admin-list-shell">
        <div class="admin-list-meta">
            <div>
                <span class="eyebrow">Library</span>
                <h3 class="admin-list-title">{{ $projects->total() }} projects</h3>
            </div>
            <p>Keep case studies clean, published intentionally, and ready for the public portfolio.</p>
        </div>

        @if($projects->count())
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Assets</th>
                            <th>Published</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td>
                                    <div class="admin-table-primary">
                                        <strong>{{ $project->title }}</strong>
                                        <div class="admin-field-help">{{ $project->slug }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span @class(['admin-badge', 'is-muted' => $project->status !== 'published'])>{{ ucfirst($project->status) }}</span>
                                </td>
                                <td>{{ $project->featured ? 'Yes' : 'No' }}</td>
                                <td class="text-[var(--muted)]">
                                    {{ $project->hero_image ? 'Hero image' : 'No hero' }} /
                                    {{ $project->screenshots->count() }} screenshots /
                                    {{ $project->files->count() }} files
                                </td>
                                <td class="text-[var(--muted)]">{{ optional($project->published_at)->format('Y-m-d') ?: 'Draft only' }}</td>
                                <td class="text-right">
                                    <div class="admin-actions-inline">
                                        <a class="btn btn-secondary btn-compact" href="{{ route('admin.projects.edit', [app()->getLocale(), $project]) }}">Edit</a>
                                        <form method="post" action="{{ route('admin.projects.destroy', [app()->getLocale(), $project]) }}" onsubmit="return confirm('Delete this project?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="admin-empty">No projects yet. Create the first case study to power the public portfolio.</div>
        @endif
    </div>

    <div class="mt-4 text-sm text-[var(--muted)]">{{ $projects->links() }}</div>
@endsection
