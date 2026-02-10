@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <p class="text-sm text-[var(--muted)]">Admin</p>
        <h1 class="text-2xl font-semibold text-[var(--text-strong)]">Overview</h1>
    </div>
</div>
<div class="grid gap-4 md:grid-cols-4">
    <div class="surface p-4">
        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[var(--muted)]">Projects</p>
        <div class="text-2xl font-semibold text-[var(--text-strong)]">{{ $stats['projects'] }}</div>
    </div>
    <div class="surface p-4">
        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[var(--muted)]">Posts</p>
        <div class="text-2xl font-semibold text-[var(--text-strong)]">{{ $stats['posts'] }}</div>
    </div>
    <div class="surface p-4">
        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[var(--muted)]">Services</p>
        <div class="text-2xl font-semibold text-[var(--text-strong)]">{{ $stats['services'] }}</div>
    </div>
    <div class="surface p-4">
        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[var(--muted)]">Leads</p>
        <div class="text-2xl font-semibold text-[var(--text-strong)]">{{ $stats['leads'] }}</div>
    </div>
</div>
<div class="mt-8 grid gap-6 lg:grid-cols-2">
    <div class="surface p-4">
        <h2 class="text-sm font-semibold text-[var(--text-strong)]">Recent leads</h2>
        <ul class="mt-4 space-y-3">
            @foreach($recentLeads as $lead)
                <li class="flex items-center justify-between text-sm text-[var(--text)]">
                    <span>{{ $lead->name }} · {{ $lead->email }}</span>
                    <span class="text-xs text-[var(--muted)]">{{ $lead->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="surface p-4">
        <h2 class="text-sm font-semibold text-[var(--text-strong)]">Recent projects</h2>
        <ul class="mt-4 space-y-3 text-sm text-[var(--text)]">
            @foreach($recentProjects as $project)
                <li class="flex items-center justify-between">
                    <span>{{ $project->title }}</span>
                    <span class="text-xs text-[var(--muted)]">{{ $project->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
