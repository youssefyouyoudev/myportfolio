@extends('layouts.admin')

@section('content')
@php
    $maxLeadTrend = max(1, collect($leadTrend)->max('value'));
    $maxTaskTrend = max(1, collect($taskTrend)->max('value'));
    $maxTaskStatus = max(1, collect($taskStatus)->max());
@endphp

<div class="mb-6 flex items-center justify-between">
    <div>
        <p class="text-sm text-[var(--muted)]">Admin Control Center</p>
        <h1 class="text-2xl font-semibold text-[var(--text-strong)]">Business Overview</h1>
        <p class="mt-1 text-sm text-[var(--muted)]">Single-owner mode · everything in one place</p>
    </div>
    <div class="text-right text-sm text-[var(--muted)]">
        <p>Current month leads: <span class="font-semibold text-[var(--text-strong)]">{{ $stats['leads_this_month'] }}</span></p>
        <p>Growth vs last month: <span class="font-semibold {{ $stats['lead_growth'] >= 0 ? 'text-emerald-400' : 'text-red-400' }}">{{ $stats['lead_growth'] }}%</span></p>
    </div>
</div>

<div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
    <div class="surface p-4">
        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[var(--muted)]">Projects</p>
        <div class="text-2xl font-semibold text-[var(--text-strong)]">{{ $stats['projects'] }}</div>
        <p class="mt-2 text-xs text-[var(--muted)]">Published: {{ $stats['projects_published'] }}</p>
    </div>
    <div class="surface p-4">
        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[var(--muted)]">Posts</p>
        <div class="text-2xl font-semibold text-[var(--text-strong)]">{{ $stats['posts'] }}</div>
        <p class="mt-2 text-xs text-[var(--muted)]">Published: {{ $stats['posts_published'] }}</p>
    </div>
    <div class="surface p-4">
        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[var(--muted)]">Leads</p>
        <div class="text-2xl font-semibold text-[var(--text-strong)]">{{ $stats['leads'] }}</div>
        <p class="mt-2 text-xs text-[var(--muted)]">This month: {{ $stats['leads_this_month'] }}</p>
    </div>
    <div class="surface p-4">
        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[var(--muted)]">Task Health</p>
        <div class="text-2xl font-semibold text-[var(--text-strong)]">{{ $stats['task_completion_rate'] }}%</div>
        <p class="mt-2 text-xs text-[var(--muted)]">Completion rate</p>
    </div>
    <div class="surface p-4">
        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[var(--muted)]">Tasks</p>
        <div class="text-2xl font-semibold text-[var(--text-strong)]">{{ $stats['tasks'] }}</div>
        <p class="mt-2 text-xs text-[var(--muted)]">In system</p>
    </div>
    <div class="surface p-4">
        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[var(--muted)]">Overdue</p>
        <div class="text-2xl font-semibold text-red-400">{{ $stats['overdue_tasks'] }}</div>
        <p class="mt-2 text-xs text-[var(--muted)]">Need immediate action</p>
    </div>
    <div class="surface p-4">
        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[var(--muted)]">Due in 7 days</p>
        <div class="text-2xl font-semibold text-amber-300">{{ $stats['due_soon_tasks'] }}</div>
        <p class="mt-2 text-xs text-[var(--muted)]">Upcoming deadlines</p>
    </div>
    <div class="surface p-4">
        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[var(--muted)]">Services</p>
        <div class="text-2xl font-semibold text-[var(--text-strong)]">{{ $stats['services'] }}</div>
        <p class="mt-2 text-xs text-[var(--muted)]">Active offerings</p>
    </div>
</div>

<div class="mt-8 grid gap-6 lg:grid-cols-3">
    <div class="surface p-4">
        <h2 class="text-sm font-semibold text-[var(--text-strong)]">Lead trend (last 6 months)</h2>
        <div class="mt-4 space-y-3">
            @foreach($leadTrend as $point)
                <div>
                    <div class="mb-1 flex items-center justify-between text-xs text-[var(--muted)]">
                        <span>{{ $point['label'] }}</span>
                        <span>{{ $point['value'] }}</span>
                    </div>
                    <div class="h-2 rounded bg-[rgba(255,255,255,0.08)]">
                        <div class="h-2 rounded bg-[var(--accent)]" style="width: {{ ($point['value'] / $maxLeadTrend) * 100 }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="surface p-4">
        <h2 class="text-sm font-semibold text-[var(--text-strong)]">Task trend (last 6 months)</h2>
        <div class="mt-4 space-y-3">
            @foreach($taskTrend as $point)
                <div>
                    <div class="mb-1 flex items-center justify-between text-xs text-[var(--muted)]">
                        <span>{{ $point['label'] }}</span>
                        <span>{{ $point['value'] }}</span>
                    </div>
                    <div class="h-2 rounded bg-[rgba(255,255,255,0.08)]">
                        <div class="h-2 rounded bg-sky-400" style="width: {{ ($point['value'] / $maxTaskTrend) * 100 }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="surface p-4">
        <h2 class="text-sm font-semibold text-[var(--text-strong)]">Task pipeline</h2>
        <ul class="mt-4 space-y-3">
            @foreach($taskStatus as $status => $count)
                <li>
                    <div class="mb-1 flex items-center justify-between text-xs text-[var(--muted)]">
                        <span>{{ str($status)->replace('_', ' ')->title() }}</span>
                        <span>{{ $count }}</span>
                    </div>
                    <div class="h-2 rounded bg-[rgba(255,255,255,0.08)]">
                        <div class="h-2 rounded bg-violet-400" style="width: {{ ($count / $maxTaskStatus) * 100 }}%"></div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<div class="mt-8 grid gap-6 lg:grid-cols-2">
    <div class="surface p-4">
        <div class="mb-3 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-[var(--text-strong)]">Recent leads</h2>
            <a href="{{ route('admin.leads.index') }}" class="text-xs text-[var(--accent-2)]">View all</a>
        </div>
        <ul class="mt-4 space-y-3">
            @forelse($recentLeads as $lead)
                <li class="flex items-center justify-between text-sm text-[var(--text)]">
                    <span>{{ $lead->name }} · {{ $lead->email }}</span>
                    <span class="text-xs text-[var(--muted)]">{{ $lead->created_at->diffForHumans() }}</span>
                </li>
            @empty
                <li class="text-sm text-[var(--muted)]">No leads yet.</li>
            @endforelse
        </ul>
    </div>

    <div class="surface p-4">
        <div class="mb-3 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-[var(--text-strong)]">Recent projects</h2>
            <a href="{{ route('admin.projects.index') }}" class="text-xs text-[var(--accent-2)]">Manage</a>
        </div>
        <ul class="mt-4 space-y-3 text-sm text-[var(--text)]">
            @forelse($recentProjects as $project)
                <li class="flex items-center justify-between">
                    <span>{{ $project->title }} <span class="text-xs text-[var(--muted)]">({{ $project->status }})</span></span>
                    <span class="text-xs text-[var(--muted)]">{{ $project->created_at->diffForHumans() }}</span>
                </li>
            @empty
                <li class="text-sm text-[var(--muted)]">No projects yet.</li>
            @endforelse
        </ul>
    </div>
</div>

<div class="mt-8 grid gap-6 lg:grid-cols-2">
    <div class="surface p-4">
        <h2 class="text-sm font-semibold text-[var(--text-strong)]">Project publication split</h2>
        <div class="mt-4 flex flex-wrap gap-2 text-xs">
            @foreach($projectStatus as $status => $count)
                <span class="chip">{{ str($status)->title() }} · {{ $count }}</span>
            @endforeach
        </div>
    </div>
    <div class="surface p-4">
        <h2 class="text-sm font-semibold text-[var(--text-strong)]">Post publication split</h2>
        <div class="mt-4 flex flex-wrap gap-2 text-xs">
            @foreach($postStatus as $status => $count)
                <span class="chip">{{ str($status)->title() }} · {{ $count }}</span>
            @endforeach
        </div>
    </div>
</div>
@endsection
