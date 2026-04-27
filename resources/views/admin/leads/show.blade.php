@extends('layouts.admin')

@section('title', 'Lead Detail')
@section('admin_title', 'Lead Detail')
@section('admin_copy', 'Review one business lead in full, update review workflow, open outreach actions, and keep status and notes aligned with your pipeline.')

@section('content')
    @php($pitches = $lead->pitches())

    <div class="admin-toolbar">
        <div>
            <span class="eyebrow">Lead detail</span>
            <h2 class="section-title">{{ $lead->business_name }}</h2>
            <p class="section-copy">
                {{ $lead->category ?: 'General business' }}
                @if($lead->city)
                    / {{ $lead->city }}
                @endif
                / {{ $lead->sourceLabel() }}
            </p>
        </div>
        <div class="admin-toolbar-actions">
            <a class="btn btn-secondary btn-compact" href="{{ route('admin.leads.edit', [app()->getLocale(), $lead]) }}">Edit lead</a>
            @if($lead->whatsappUrl())
                <a class="btn btn-primary btn-compact" href="{{ $lead->whatsappUrl() }}" target="_blank" rel="noopener">Open WhatsApp</a>
            @endif
            <button
                type="button"
                class="btn btn-secondary btn-compact"
                data-copy-text="{{ $pitches['whatsapp_pitch'] ?? $lead->outreachMessage() }}"
                data-copy-success="Pitch copied"
            >
                Copy message
            </button>
        </div>
    </div>

    <div class="admin-toolbar-actions admin-toolbar-actions-split">
        <form method="post" action="{{ route('admin.leads.review', [app()->getLocale(), $lead]) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="review_status" value="approved">
            <button class="btn btn-secondary btn-compact" type="submit">Approve</button>
        </form>
        <form method="post" action="{{ route('admin.leads.review', [app()->getLocale(), $lead]) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="review_status" value="rejected">
            <button class="btn btn-secondary btn-compact" type="submit">Reject</button>
        </form>
        <form method="post" action="{{ route('admin.leads.mark-hot', [app()->getLocale(), $lead]) }}">
            @csrf
            @method('PATCH')
            <button class="btn btn-primary btn-compact" type="submit">Mark hot</button>
        </form>
    </div>

    <div class="admin-detail-grid">
        <article class="panel admin-module-card">
            <span class="eyebrow">Lead info</span>
            <div class="admin-detail-list">
                <div class="admin-detail-item">
                    <strong>Review</strong>
                    <span><span @class(['admin-badge', $lead->reviewTone()])>{{ $lead->reviewLabel() }}</span></span>
                </div>
                <div class="admin-detail-item">
                    <strong>Status</strong>
                    <span><span @class(['admin-badge', $lead->statusTone()])>{{ $lead->statusLabel() }}</span></span>
                </div>
                <div class="admin-detail-item">
                    <strong>Opportunity score</strong>
                    <span>{{ $lead->online_presence_score !== null ? $lead->online_presence_score.'/100' : 'Not scored' }}</span>
                </div>
                <div class="admin-detail-item">
                    <strong>Estimated revenue</strong>
                    <span>{{ $lead->estimated_revenue ? number_format((float) $lead->estimated_revenue, 0).' MAD' : 'Not set' }}</span>
                </div>
            </div>
        </article>

        <article class="panel admin-module-card">
            <span class="eyebrow">Contact channels</span>
            <div class="admin-detail-list">
                <div class="admin-detail-item">
                    <strong>Phone</strong>
                    <span>{{ $lead->phone ?: 'Not available' }}</span>
                </div>
                <div class="admin-detail-item">
                    <strong>Email</strong>
                    <span>{{ $lead->email ?: 'Not available' }}</span>
                </div>
                <div class="admin-detail-item">
                    <strong>Website</strong>
                    <span>
                        @if($lead->website)
                            <a href="{{ $lead->website }}" target="_blank" rel="noopener">{{ $lead->website }}</a>
                        @else
                            Not available
                        @endif
                    </span>
                </div>
                <div class="admin-detail-item">
                    <strong>Replies</strong>
                    <span>{{ $lead->reply_count }}</span>
                </div>
            </div>
        </article>
    </div>

    @if($lead->issues())
        <article class="panel admin-module-card">
            <span class="eyebrow">Opportunity signals</span>
            <div class="stack-list">
                @foreach($lead->issues() as $issue)
                    <span>{{ $issue }}</span>
                @endforeach
            </div>
        </article>
    @endif

    @if($pitches)
        <div class="admin-detail-grid">
            <article class="panel admin-module-card">
                <span class="eyebrow">WhatsApp pitch</span>
                <div class="admin-note-block">{{ $pitches['whatsapp_pitch'] ?? '' }}</div>
            </article>
            <article class="panel admin-module-card">
                <span class="eyebrow">Email pitch</span>
                <div class="admin-note-block">{{ $pitches['email_pitch'] ?? '' }}</div>
            </article>
            <article class="panel admin-module-card">
                <span class="eyebrow">Follow-up message</span>
                <div class="admin-note-block">{{ $pitches['follow_up_message'] ?? '' }}</div>
            </article>
            <article class="panel admin-module-card">
                <span class="eyebrow">Free audit message</span>
                <div class="admin-note-block">{{ $pitches['free_audit_message'] ?? '' }}</div>
            </article>
        </div>
    @endif

    <article class="panel admin-module-card">
        <span class="eyebrow">Notes</span>
        <div class="admin-note-block">{{ $lead->notes ?: 'No notes added yet.' }}</div>
    </article>

    <div class="admin-toolbar-actions">
        <a class="btn btn-secondary btn-compact" href="{{ route('admin.leads.index', app()->getLocale()) }}">Back to leads</a>
        <form method="post" action="{{ route('admin.leads.destroy', [app()->getLocale(), $lead]) }}" onsubmit="return confirm('Delete this lead?');">
            @csrf
            @method('DELETE')
            <button class="btn-danger" type="submit">Delete</button>
        </form>
    </div>
@endsection
