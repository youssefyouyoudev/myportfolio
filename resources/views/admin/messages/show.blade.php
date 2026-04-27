@extends('layouts.admin')

@section('title', 'Message Detail')
@section('admin_title', 'Message Detail')
@section('admin_copy', 'Review the full enquiry, mark it read or unread, and decide whether it should stay in the inbox or move into a manual CRM process.')

@section('content')
    <div class="admin-toolbar">
        <div>
            <span class="eyebrow">Message detail</span>
            <h2 class="section-title">{{ $message->name }}</h2>
            <p class="section-copy">{{ $message->email }} @if($message->company) / {{ $message->company }} @endif</p>
        </div>
        <div class="admin-toolbar-actions">
            <a class="btn btn-primary btn-compact" href="mailto:{{ $message->email }}">Reply by email</a>
            <form method="post" action="{{ route('admin.messages.toggle-read', [app()->getLocale(), $message]) }}">
                @csrf
                @method('PATCH')
                <button class="btn btn-secondary btn-compact" type="submit">{{ $message->read_at ? 'Mark unread' : 'Mark read' }}</button>
            </form>
            <form method="post" action="{{ route('admin.messages.destroy', [app()->getLocale(), $message]) }}" onsubmit="return confirm('Delete this message?');">
                @csrf
                @method('DELETE')
                <button class="btn-danger" type="submit">Delete</button>
            </form>
        </div>
    </div>

    <div class="admin-detail-grid">
        <article class="panel admin-module-card">
            <span class="eyebrow">Context</span>
            <div class="admin-detail-list">
                <div class="admin-detail-item">
                    <strong>Status</strong>
                    <span><span @class(['admin-badge', 'is-success' => $message->read_at, 'is-warm' => !$message->read_at])>{{ $message->read_at ? 'Read' : 'Unread' }}</span></span>
                </div>
                <div class="admin-detail-item">
                    <strong>Project type</strong>
                    <span>{{ $message->project_type ?: 'General enquiry' }}</span>
                </div>
                <div class="admin-detail-item">
                    <strong>Budget</strong>
                    <span>{{ $message->budget ?: 'Not specified' }}</span>
                </div>
                <div class="admin-detail-item">
                    <strong>Timeline</strong>
                    <span>{{ $message->timeline ?: 'Not specified' }}</span>
                </div>
                <div class="admin-detail-item">
                    <strong>Source</strong>
                    <span>{{ $message->source ?: 'website' }}</span>
                </div>
                <div class="admin-detail-item">
                    <strong>Received</strong>
                    <span>{{ $message->created_at?->format('Y-m-d H:i') }}</span>
                </div>
            </div>
        </article>

        <article class="panel admin-module-card">
            <span class="eyebrow">Delivery data</span>
            <div class="admin-detail-list">
                <div class="admin-detail-item">
                    <strong>Locale</strong>
                    <span>{{ strtoupper($message->locale) }}</span>
                </div>
                <div class="admin-detail-item">
                    <strong>Path</strong>
                    <span>{{ $message->path ?: 'Not captured' }}</span>
                </div>
                <div class="admin-detail-item">
                    <strong>IP address</strong>
                    <span>{{ $message->ip_address ?: 'Not captured' }}</span>
                </div>
                <div class="admin-detail-item">
                    <strong>User agent</strong>
                    <span>{{ $message->user_agent ?: 'Not captured' }}</span>
                </div>
            </div>
        </article>
    </div>

    <article class="panel admin-module-card">
        <span class="eyebrow">Message body</span>
        <div class="admin-note-block">{{ $message->message }}</div>
    </article>

    <div class="admin-toolbar-actions">
        <a class="btn btn-secondary btn-compact" href="{{ route('admin.messages.index', app()->getLocale()) }}">Back to messages</a>
    </div>
@endsection
