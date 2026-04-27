@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('admin_title', 'Admin Dashboard')
@section('admin_copy', 'Private control center for managing portfolio content, publishing workflows, and inbound demand signals.')

@section('content')
    @php
        $primaryCrmCards = collect($crmCards)->take(4);
        $secondaryCrmCards = collect($crmCards)->slice(4);
        $quickLinks = [
            ['label' => 'New project', 'href' => route('admin.projects.create', ['locale' => app()->getLocale()])],
            ['label' => 'New post', 'href' => route('admin.posts.create', ['locale' => app()->getLocale()])],
            ['label' => 'Add lead', 'href' => route('admin.leads.create', ['locale' => app()->getLocale()])],
            ['label' => 'Open inbox', 'href' => route('admin.messages.index', ['locale' => app()->getLocale()])],
        ];
    @endphp

    <section class="admin-overview-grid">
        <article class="panel admin-hero-card">
            <div>
                <span class="eyebrow">Content + CRM</span>
                <h2>Everything important is in one private workspace.</h2>
                <p>Publish portfolio content, review enquiries, manage leads, and move opportunities forward without jumping between disconnected tools.</p>
            </div>

            <div class="admin-foundation-list">
                @foreach($foundation as $item)
                    <span>{{ $item }}</span>
                @endforeach
            </div>
        </article>

        <article class="panel admin-note-card">
            <span class="eyebrow">Work faster</span>
            <h2>Prioritize what needs action first.</h2>
            <p>Unread messages, hot leads, and fresh finder results stay visible so follow-up work never gets buried under publishing tasks.</p>
            <div class="admin-quick-links">
                @foreach($quickLinks as $link)
                    <a href="{{ $link['href'] }}" class="btn btn-secondary btn-compact">{{ $link['label'] }}</a>
                @endforeach
            </div>
        </article>
    </section>

    <section class="admin-section-stack">
        <div class="admin-section-head">
            <div>
                <span class="eyebrow">Priority</span>
                <h2 class="section-title">What needs attention now</h2>
                <p class="section-copy">The highest-signal CRM numbers stay first so the dashboard is useful in a few seconds.</p>
            </div>
        </div>

        <div class="admin-card-grid admin-card-grid-priority">
            @foreach($primaryCrmCards as $card)
                <article class="panel admin-stat-card">
                    <span class="admin-stat-label">{{ $card['label'] }}</span>
                    <strong>{{ $card['value'] }}</strong>
                    <p>{{ $card['copy'] }}</p>
                    <small>{{ $card['note'] }}</small>
                    @if(!empty($card['href']))
                        <a href="{{ $card['href'] }}" class="text-link">Open module</a>
                    @endif
                </article>
            @endforeach
        </div>
    </section>

    <section class="admin-detail-grid">
        <article class="panel admin-module-card">
            <span class="eyebrow">Latest content</span>
            <h2>Quick visibility into the latest portfolio updates.</h2>
            <div class="admin-content-grid">
                @foreach($latestContent as $group)
                    <div class="admin-content-column">
                        <strong>{{ $group['label'] }}</strong>
                        <ul class="admin-content-list">
                            @forelse($group['items'] as $item)
                                <li>
                                    <a href="{{ $item['href'] }}">{{ $item['title'] }}</a>
                                    <span>{{ $item['meta'] }}</span>
                                </li>
                            @empty
                                <li class="is-empty">
                                    <span>{{ $group['empty'] }}</span>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                @endforeach
            </div>
        </article>

        <article class="panel admin-module-card">
            <span class="eyebrow">Operational focus</span>
            <h2>What this admin is optimized to support right now.</h2>
            <ul class="simple-list">
                <li>Project management and case-study publishing</li>
                <li>Blog post drafting and SEO publishing workflows</li>
                <li>Service page editing and offer management</li>
                <li>Testimonial curation for trust and conversion</li>
                <li>Message triage and manual lead follow-up visibility</li>
            </ul>
        </article>
    </section>

    <section class="admin-detail-grid">
        <article class="panel admin-module-card">
            <span class="eyebrow">Pipeline metrics</span>
            <h2>Secondary CRM signals</h2>
            <div class="admin-card-grid admin-card-grid-compact">
                @foreach($secondaryCrmCards as $card)
                    <article class="admin-subtle-card">
                        <span class="admin-stat-label">{{ $card['label'] }}</span>
                        <strong>{{ $card['value'] }}</strong>
                        <small>{{ $card['note'] }}</small>
                        @if(!empty($card['href']))
                            <a href="{{ $card['href'] }}" class="text-link">Open</a>
                        @endif
                    </article>
                @endforeach
            </div>
        </article>

        <article class="panel admin-module-card">
            <span class="eyebrow">Publishing modules</span>
            <h2>Content inventory at a glance</h2>
            <div class="admin-card-grid admin-card-grid-compact">
                @foreach($contentCards as $card)
                    <article class="admin-subtle-card">
                        <span class="admin-stat-label">{{ $card['label'] }}</span>
                        <strong>{{ $card['value'] }}</strong>
                        <small>{{ $card['note'] }}</small>
                        @if(!empty($card['href']))
                            <a href="{{ $card['href'] }}" class="text-link">Open</a>
                        @endif
                    </article>
                @endforeach

                @foreach($agentCards as $card)
                    <article class="admin-subtle-card">
                        <span class="admin-stat-label">{{ $card['label'] }}</span>
                        <strong>{{ $card['value'] }}</strong>
                        <small>{{ $card['note'] }}</small>
                        @if(!empty($card['href']))
                            <a href="{{ $card['href'] }}" class="text-link">Open</a>
                        @endif
                    </article>
                @endforeach
            </div>
        </article>
    </section>

    <section class="admin-detail-grid">
        <article class="panel admin-module-card">
            <span class="eyebrow">Recent messages</span>
            <h2>Latest inbound contact activity.</h2>
            <ul class="admin-message-list">
                @forelse($recentMessages as $message)
                    <li>
                        <strong>{{ $message->name }}</strong>
                        <span>{{ $message->email }} @if($message->company) / {{ $message->company }} @endif</span>
                        <small>{{ $message->created_at?->diffForHumans() }}</small>
                    </li>
                @empty
                    <li class="is-empty">
                        <strong>No messages yet</strong>
                        <span>New contact form submissions will appear here.</span>
                    </li>
                @endforelse
            </ul>
        </article>

        <article class="panel admin-module-card">
            <span class="eyebrow">Recent leads</span>
            <h2>Manual CRM records that need context or follow-up.</h2>
            <ul class="admin-message-list">
                @forelse($recentLeads as $lead)
                    <li>
                        <strong>{{ $lead->business_name }}</strong>
                        <span>{{ $lead->statusLabel() }} @if($lead->city) / {{ $lead->city }} @endif</span>
                        <small>{{ $lead->updated_at?->diffForHumans() }}</small>
                    </li>
                @empty
                    <li class="is-empty">
                        <strong>No leads yet</strong>
                        <span>Add the first business lead to start the CRM pipeline.</span>
                    </li>
                @endforelse
            </ul>
        </article>
    </section>
@endsection
