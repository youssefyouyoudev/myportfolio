@extends('layouts.admin')

@section('title', 'Contact Messages')
@section('admin_title', 'Contact Messages')
@section('admin_copy', 'Review website enquiries, track unread submissions, and open individual message details without mixing them into the CRM pipeline.')

@section('content')
    <div class="admin-toolbar">
        <div>
            <span class="eyebrow">Inbox</span>
            <h2 class="section-title">Website messages</h2>
            <p class="section-copy">Messages come directly from the public contact form and can be marked read or unread as you triage them.</p>
        </div>
    </div>

    <div class="admin-kpi-grid">
        <article class="panel admin-kpi-card">
            <span>Total messages</span>
            <strong>{{ $stats['total'] }}</strong>
        </article>
        <article class="panel admin-kpi-card">
            <span>Unread</span>
            <strong>{{ $stats['unread'] }}</strong>
        </article>
        <article class="panel admin-kpi-card">
            <span>Read</span>
            <strong>{{ $stats['read'] }}</strong>
        </article>
    </div>

    <form method="get" class="panel admin-filter-bar">
        <div class="admin-filter-grid three">
            <label class="admin-field">
                <span>Filter</span>
                <select class="input-ghost" name="filter">
                    <option value="all" @selected($filter === 'all')>All</option>
                    <option value="unread" @selected($filter === 'unread')>Unread</option>
                    <option value="read" @selected($filter === 'read')>Read</option>
                </select>
            </label>
        </div>
        <div class="admin-toolbar-actions">
            <button type="submit" class="btn btn-primary btn-compact">Apply</button>
            <a href="{{ route('admin.messages.index', app()->getLocale()) }}" class="btn btn-secondary btn-compact">Reset</a>
        </div>
    </form>

    <div class="surface admin-list-shell">
        <div class="admin-list-meta">
            <div>
                <span class="eyebrow">Inbox</span>
                <h3 class="admin-list-title">{{ $messages->total() }} messages in view</h3>
            </div>
            <p>Use the inbox like a triage queue: open, reply, mark read, then move on.</p>
        </div>

        @if($messages->count())
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Sender</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Timeline</th>
                            <th>Received</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                            <tr>
                                <td>
                                    <div class="admin-table-primary">
                                        <strong>{{ $message->name }}</strong>
                                        <div class="admin-field-help">{{ $message->email }} @if($message->company) / {{ $message->company }} @endif</div>
                                    </div>
                                </td>
                                <td class="text-[var(--muted)]">{{ $message->project_type ?: 'General enquiry' }}</td>
                                <td>
                                    <span @class(['admin-badge', 'is-success' => $message->read_at, 'is-warm' => !$message->read_at])>
                                        {{ $message->read_at ? 'Read' : 'Unread' }}
                                    </span>
                                </td>
                                <td class="text-[var(--muted)]">{{ $message->timeline ?: 'Not specified' }}</td>
                                <td class="text-[var(--muted)]">{{ $message->created_at?->format('Y-m-d H:i') }}</td>
                                <td class="text-right">
                                    <div class="admin-actions-inline">
                                        <a class="btn btn-secondary btn-compact" href="{{ route('admin.messages.show', [app()->getLocale(), $message]) }}">Open</a>
                                        <form method="post" action="{{ route('admin.messages.toggle-read', [app()->getLocale(), $message]) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-secondary btn-compact" type="submit">{{ $message->read_at ? 'Unread' : 'Read' }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="admin-empty">No contact messages found for this filter.</div>
        @endif
    </div>

    <div class="mt-4 text-sm text-[var(--muted)]">{{ $messages->links() }}</div>
@endsection
