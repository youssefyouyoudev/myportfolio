@extends('layouts.admin')

@section('title', 'Leads CRM')
@section('admin_title', 'Leads CRM')
@section('admin_copy', 'Track business leads manually, filter pipeline stages, review finder imports, and keep outreach context in one private CRM view.')

@section('content')
    <div class="admin-toolbar">
        <div>
            <span class="eyebrow">Private CRM</span>
            <h2 class="section-title">Lead pipeline</h2>
            <p class="section-copy">Use this module for manual leads and agent-discovered businesses that need review before outreach.</p>
        </div>
        <div class="admin-toolbar-actions">
            <a class="btn btn-secondary btn-compact" href="{{ route('admin.lead-finder.index', app()->getLocale()) }}">Open lead finder</a>
            <a class="btn btn-primary btn-compact" href="{{ route('admin.leads.create', app()->getLocale()) }}">Add lead</a>
        </div>
    </div>

    <div class="admin-kpi-grid four">
        <article class="panel admin-kpi-card">
            <span>Total leads</span>
            <strong>{{ $stats['total'] }}</strong>
        </article>
        <article class="panel admin-kpi-card">
            <span>Found today</span>
            <strong>{{ $stats['found_today'] }}</strong>
        </article>
        <article class="panel admin-kpi-card">
            <span>Hot</span>
            <strong>{{ $stats['hot'] }}</strong>
        </article>
        <article class="panel admin-kpi-card">
            <span>Replies</span>
            <strong>{{ $stats['replies'] }}</strong>
        </article>
    </div>

    <div class="admin-kpi-grid">
        <article class="panel admin-kpi-card">
            <span>Contacted</span>
            <strong>{{ $stats['contacted'] }}</strong>
        </article>
        <article class="panel admin-kpi-card">
            <span>Closed</span>
            <strong>{{ $stats['closed'] }}</strong>
        </article>
        <article class="panel admin-kpi-card">
            <span>Estimated revenue</span>
            <strong>{{ number_format($stats['estimated_revenue'], 0) }} MAD</strong>
        </article>
    </div>

    <form method="get" class="panel admin-filter-bar">
        <div class="admin-filter-grid four">
            <label class="admin-field">
                <span>Status</span>
                <select class="input-ghost" name="status">
                    <option value="">All statuses</option>
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>

            <label class="admin-field">
                <span>Review</span>
                <select class="input-ghost" name="review_status">
                    <option value="">All review states</option>
                    @foreach($reviewStatuses as $value => $label)
                        <option value="{{ $value }}" @selected($filters['review_status'] === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>

            <label class="admin-field">
                <span>City</span>
                <select class="input-ghost" name="city">
                    <option value="">All cities</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" @selected($filters['city'] === $city)>{{ $city }}</option>
                    @endforeach
                </select>
            </label>

            <label class="admin-field">
                <span>Category</span>
                <select class="input-ghost" name="category">
                    <option value="">All categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" @selected($filters['category'] === $category)>{{ $category }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="admin-filter-grid">
            <label class="admin-field">
                <span>Search</span>
                <input class="input-ghost" type="search" name="search" value="{{ $filters['search'] }}" placeholder="Business, phone, email, website, notes...">
            </label>
        </div>

        <div class="admin-toolbar-actions">
            <button type="submit" class="btn btn-primary btn-compact">Apply filters</button>
            <a href="{{ route('admin.leads.index', app()->getLocale()) }}" class="btn btn-secondary btn-compact">Reset</a>
        </div>
    </form>

    <div class="surface admin-list-shell">
        <div class="admin-list-meta">
            <div>
                <span class="eyebrow">Lead list</span>
                <h3 class="admin-list-title">{{ $leads->total() }} leads in view</h3>
            </div>
            <p>Search, filter, and open records quickly without leaving the pipeline.</p>
        </div>

        @if($leads->count())
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Business</th>
                            <th>Review</th>
                            <th>Status</th>
                            <th>Opportunity</th>
                            <th>Source</th>
                            <th>Contact</th>
                            <th>Updated</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leads as $lead)
                            <tr>
                                <td>
                                    <div class="admin-table-primary">
                                        <strong>{{ $lead->business_name }}</strong>
                                        <div class="admin-field-help">
                                            {{ $lead->category ?: 'General business' }}
                                            @if($lead->city)
                                                / {{ $lead->city }}
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td><span @class(['admin-badge', $lead->reviewTone()])>{{ $lead->reviewLabel() }}</span></td>
                                <td><span @class(['admin-badge', $lead->statusTone()])>{{ $lead->statusLabel() }}</span></td>
                                <td>
                                    <span class="admin-score-pill">
                                        {{ $lead->online_presence_score !== null ? $lead->online_presence_score.'/100' : 'Not scored' }}
                                    </span>
                                </td>
                                <td class="text-[var(--muted)]">{{ $lead->sourceLabel() }}</td>
                                <td class="text-[var(--muted)]">{{ $lead->phone ?: ($lead->email ?: 'No direct contact') }}</td>
                                <td class="text-[var(--muted)]">{{ $lead->updated_at?->format('Y-m-d') }}</td>
                                <td class="text-right">
                                    <div class="admin-actions-inline">
                                        <a class="btn btn-secondary btn-compact" href="{{ route('admin.leads.show', [app()->getLocale(), $lead]) }}">Open</a>
                                        <a class="btn btn-secondary btn-compact" href="{{ route('admin.leads.edit', [app()->getLocale(), $lead]) }}">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="admin-empty">No leads found. Add the first lead manually or use the lead finder agent.</div>
        @endif
    </div>

    <div class="mt-4 text-sm text-[var(--muted)]">{{ $leads->links() }}</div>
@endsection
