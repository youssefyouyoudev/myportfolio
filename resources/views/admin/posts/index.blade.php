@extends('layouts.admin')

@section('title', 'Blog Posts')
@section('admin_title', 'Blog Posts')
@section('admin_copy', 'Manage articles, publish insights, and control which posts should be featured on the personal brand site.')

@section('content')
    <div class="admin-toolbar">
        <div>
            <span class="eyebrow">Content module</span>
            <h2 class="section-title">Blog content</h2>
            <p class="section-copy">Use published posts to power the public insights section without touching the frontend layout.</p>
        </div>
        <div class="admin-toolbar-actions">
            <a class="btn btn-primary btn-compact" href="{{ route('admin.posts.create', app()->getLocale()) }}">New post</a>
        </div>
    </div>

    <div class="surface admin-list-shell">
        <div class="admin-list-meta">
            <div>
                <span class="eyebrow">Editorial</span>
                <h3 class="admin-list-title">{{ $posts->total() }} posts</h3>
            </div>
            <p>Keep insights organized, SEO-ready, and easy to publish when they are ready.</p>
        </div>

        @if($posts->count())
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Post</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Cover</th>
                            <th>Published</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>
                                    <div class="admin-table-primary">
                                        <strong>{{ $post->title }}</strong>
                                        <div class="admin-field-help">{{ $post->slug }}</div>
                                    </div>
                                </td>
                                <td><span @class(['admin-badge', 'is-muted' => $post->status !== 'published'])>{{ ucfirst($post->status) }}</span></td>
                                <td>{{ $post->featured ? 'Yes' : 'No' }}</td>
                                <td class="text-[var(--muted)]">{{ $post->cover_image ? 'Available' : 'No cover' }}</td>
                                <td class="text-[var(--muted)]">{{ optional($post->published_at)->format('Y-m-d') ?: 'Draft only' }}</td>
                                <td class="text-right">
                                    <div class="admin-actions-inline">
                                        <a class="btn btn-secondary btn-compact" href="{{ route('admin.posts.edit', [app()->getLocale(), $post]) }}">Edit</a>
                                        <form method="post" action="{{ route('admin.posts.destroy', [app()->getLocale(), $post]) }}" onsubmit="return confirm('Delete this post?');">
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
            <div class="admin-empty">No blog posts yet. Create the first article to activate dynamic insights.</div>
        @endif
    </div>

    <div class="mt-4 text-sm text-[var(--muted)]">{{ $posts->links() }}</div>
@endsection
