@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <h1 class="text-2xl font-semibold text-[var(--text-strong)]">Tasks Gantt</h1>
    <div class="flex gap-2">
        <a class="btn-primary text-sm" href="{{ route('admin.tasks.index') }}">List</a>
        <a class="btn-primary text-sm" href="{{ route('admin.tasks.kanban') }}">Kanban</a>
    </div>
</div>

<div class="surface overflow-hidden p-4">
    @php
        $minStart = optional($tasks->min('start_date'));
        $maxEnd = optional($tasks->max('due_date'));
        $totalDays = $minStart && $maxEnd ? max(1, $minStart->diffInDays($maxEnd) + 1) : 1;
    @endphp

    <div class="space-y-4">
        @forelse($tasks as $task)
            @php
                $offset = max(0, $minStart?->diffInDays($task->start_date ?? $minStart) ?? 0);
                $duration = max(1, optional($task->start_date)->diffInDays($task->due_date) + 1);
                $left = ($offset / $totalDays) * 100;
                $width = ($duration / $totalDays) * 100;
            @endphp
            <div>
                <div class="mb-1 flex items-center justify-between text-xs text-[var(--muted)]">
                    <span>{{ $task->title }} · {{ $task->project?->title ?? 'General' }}</span>
                    <span>{{ optional($task->start_date)->format('Y-m-d') }} → {{ optional($task->due_date)->format('Y-m-d') }}</span>
                </div>
                <div class="relative h-8 rounded-lg border border-[var(--border)] bg-[color-mix(in_srgb,var(--card)_70%,transparent)]">
                    <div class="absolute top-1 h-6 rounded-md bg-[var(--accent)]" style="left: {{ $left }}%; width: {{ $width }}%"></div>
                </div>
            </div>
        @empty
            <p class="text-sm text-[var(--muted)]">No planned tasks with date ranges yet.</p>
        @endforelse
    </div>
</div>
@endsection
