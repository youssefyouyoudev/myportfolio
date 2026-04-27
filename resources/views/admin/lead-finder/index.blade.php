@extends('layouts.admin')

@section('title', 'AI Lead Finder')
@section('admin_title', 'AI Lead Finder')
@section('admin_copy', 'Search safe business sources, score weak online presence, generate outreach copy, and import selected leads into CRM for review.')

@section('content')
    @php
        $resultCount = count($results ?? []);
        $importedCount = collect($results ?? [])->where('imported', true)->count();
        $missingWebsiteCount = collect($results ?? [])->filter(fn ($result) => empty($result['website']))->count();
        $withPhoneCount = collect($results ?? [])->filter(fn ($result) => !empty($result['phone']))->count();
    @endphp

    <div class="admin-toolbar">
        <div>
            <span class="eyebrow">Private agent</span>
            <h2 class="section-title">Lead finder workspace</h2>
            <p class="section-copy">Uses OpenStreetMap and Overpass-based business discovery, then scores each lead for weak online presence before anything is saved.</p>
        </div>
        <div class="admin-toolbar-actions">
            <a class="btn btn-secondary btn-compact" href="{{ route('admin.leads.index', app()->getLocale()) }}">View CRM leads</a>
        </div>
    </div>

    @error('lead_finder')
        <div class="status-banner status-banner-error" role="alert">{{ $message }}</div>
    @enderror

    <form method="post" action="{{ route('admin.lead-finder.search', app()->getLocale()) }}" class="panel admin-form">
        @csrf

        <div>
            <span class="eyebrow">Search inputs</span>
            <h2 class="section-title">City, category, country, and result size</h2>
        </div>

        <div class="admin-form-grid four">
            <label class="admin-field">
                <span>City</span>
                <input class="input-ghost" type="text" name="city" value="{{ old('city', $search['city'] ?? '') }}" required>
            </label>

            <label class="admin-field">
                <span>Category</span>
                <input class="input-ghost" type="text" name="category" value="{{ old('category', $search['category'] ?? '') }}" placeholder="restaurant, clinic, salon..." required>
            </label>

            <label class="admin-field">
                <span>Country</span>
                <input class="input-ghost" type="text" name="country" value="{{ old('country', $search['country'] ?? 'Morocco') }}" required>
            </label>

            <label class="admin-field">
                <span>Max results</span>
                <input class="input-ghost" type="number" min="1" max="25" name="max_results" value="{{ old('max_results', $search['max_results'] ?? 10) }}" required>
            </label>
        </div>

        <div class="admin-toolbar-actions">
            <button type="submit" class="btn btn-primary btn-compact">Run lead finder</button>
        </div>
    </form>

    @if($results)
        <div class="admin-kpi-grid four">
            <article class="panel admin-kpi-card">
                <span>Candidates</span>
                <strong>{{ $resultCount }}</strong>
            </article>
            <article class="panel admin-kpi-card">
                <span>Already imported</span>
                <strong>{{ $importedCount }}</strong>
            </article>
            <article class="panel admin-kpi-card">
                <span>No website</span>
                <strong>{{ $missingWebsiteCount }}</strong>
            </article>
            <article class="panel admin-kpi-card">
                <span>Phone found</span>
                <strong>{{ $withPhoneCount }}</strong>
            </article>
        </div>

        <div class="admin-toolbar">
            <div>
                <span class="eyebrow">Search results</span>
                <h2 class="section-title">{{ $resultCount }} candidates ready for review</h2>
                <p class="section-copy">
                    @if($searchedAt)
                        Last search: {{ \Illuminate\Support\Carbon::parse($searchedAt)->format('Y-m-d H:i') }}
                    @endif
                </p>
            </div>
        </div>

        <form method="post" action="{{ route('admin.lead-finder.import', app()->getLocale()) }}" class="admin-form">
            @csrf

            <div class="panel admin-form-section admin-review-bar">
                <label class="admin-check">
                    <input type="checkbox" name="mark_hot" value="1">
                    <span>Mark imported leads as hot immediately</span>
                </label>

                <div class="admin-toolbar-actions">
                    <button type="submit" name="scope" value="selected" class="btn btn-primary btn-compact">Import selected</button>
                    <button type="submit" name="scope" value="all" class="btn btn-secondary btn-compact">Import all visible</button>
                </div>
            </div>

            <div class="admin-detail-grid">
                @foreach($results as $result)
                    <article class="panel admin-module-card admin-review-card">
                        <div class="admin-review-card-head">
                            <label class="admin-check">
                                <input type="checkbox" name="selected[]" value="{{ $result['fingerprint'] ?? '' }}" @checked(!($result['imported'] ?? false)) @disabled($result['imported'] ?? false)>
                                <span>{{ ($result['imported'] ?? false) ? 'Already imported' : 'Select for import' }}</span>
                            </label>
                            <span class="admin-score-pill">Score {{ $result['online_presence_score'] ?? 0 }}/100</span>
                        </div>

                        <div>
                            <strong>{{ $result['business_name'] }}</strong>
                            <div class="admin-field-help">
                                {{ $result['category'] ?? 'Business' }}
                                @if(!empty($result['city']))
                                    / {{ $result['city'] }}
                                @endif
                                @if(!empty($result['country']))
                                    / {{ $result['country'] }}
                                @endif
                            </div>
                        </div>

                        <div class="stack-list">
                            <span>{{ $result['source_label'] ?? 'OpenStreetMap' }}</span>
                            <span>{{ !empty($result['website']) ? 'Website found' : 'No website' }}</span>
                            @if(!empty($result['phone']))
                                <span>Phone available</span>
                            @endif
                        </div>

                        @if(!empty($result['online_presence_issues']))
                            <div class="admin-signal-list">
                                @foreach($result['online_presence_issues'] as $issue)
                                    <span>{{ $issue }}</span>
                                @endforeach
                            </div>
                        @endif

                        <div class="admin-detail-list">
                            <div class="admin-detail-item">
                                <strong>Phone</strong>
                                <span>{{ $result['phone'] ?: 'Not available' }}</span>
                            </div>
                            <div class="admin-detail-item">
                                <strong>Email</strong>
                                <span>{{ $result['email'] ?: 'Not available' }}</span>
                            </div>
                            <div class="admin-detail-item">
                                <strong>Website</strong>
                                <span>
                                    @if(!empty($result['website']))
                                        <a href="{{ $result['website'] }}" target="_blank" rel="noopener">{{ $result['website'] }}</a>
                                    @else
                                        Not available
                                    @endif
                                </span>
                            </div>
                            <div class="admin-detail-item">
                                <strong>Estimated revenue</strong>
                                <span>{{ !empty($result['estimated_revenue']) ? number_format((float) $result['estimated_revenue'], 0).' MAD' : 'Not estimated' }}</span>
                            </div>
                        </div>

                        @if(!empty($result['pitch_payload']))
                            <details class="admin-collapse">
                                <summary>Generated outreach messages</summary>
                                <div class="admin-detail-list">
                                    <div class="admin-detail-item">
                                        <strong>WhatsApp pitch</strong>
                                        <span>{{ $result['pitch_payload']['whatsapp_pitch'] ?? '' }}</span>
                                    </div>
                                    <div class="admin-detail-item">
                                        <strong>Email pitch</strong>
                                        <span>{{ $result['pitch_payload']['email_pitch'] ?? '' }}</span>
                                    </div>
                                    <div class="admin-detail-item">
                                        <strong>Follow-up message</strong>
                                        <span>{{ $result['pitch_payload']['follow_up_message'] ?? '' }}</span>
                                    </div>
                                    <div class="admin-detail-item">
                                        <strong>Free audit message</strong>
                                        <span>{{ $result['pitch_payload']['free_audit_message'] ?? '' }}</span>
                                    </div>
                                </div>
                            </details>
                        @endif
                    </article>
                @endforeach
            </div>
        </form>
    @endif
@endsection
