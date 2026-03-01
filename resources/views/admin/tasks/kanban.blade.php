@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <h1 class="text-2xl font-semibold text-[var(--text-strong)]">Tasks Kanban</h1>
    <div class="flex gap-2">
        <a class="btn-primary text-sm" href="{{ route('admin.tasks.index') }}">List</a>
        <a class="btn-primary text-sm" href="{{ route('admin.tasks.gantt') }}">Gantt</a>
    </div>
</div>

<div class="mb-4 rounded-lg border border-[var(--border)] bg-[color-mix(in_srgb,var(--card)_85%,transparent)] px-3 py-2 text-xs text-[var(--muted)]">
    Drag a task card and drop it in another column to update status.
</div>

<div id="kanban-board" class="grid gap-4 lg:grid-cols-4" data-csrf="{{ csrf_token() }}">
    @foreach($columns as $status => $label)
        <div class="surface p-4" data-column="{{ $status }}">
            <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-[var(--muted)]">{{ $label }}</h2>
            <div class="space-y-3 min-h-24 rounded-lg border border-dashed border-transparent p-1 transition" data-dropzone="{{ $status }}">
                @forelse($tasks->where('status', $status) as $task)
                    <article
                        class="rounded-lg border border-[var(--border)] bg-[color-mix(in_srgb,var(--card)_92%,transparent)] p-3 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                        data-task-id="{{ $task->id }}"
                        data-current-status="{{ $task->status }}"
                        draggable="true"
                    >
                        <a href="{{ route('admin.tasks.edit', [app()->getLocale(), $task]) }}" class="font-semibold text-[var(--text-strong)]">{{ $task->title }}</a>
                        <p class="mt-1 text-xs text-[var(--muted)]">{{ $task->project?->title ?? 'General' }} · {{ strtoupper($task->priority) }}</p>
                        <p class="mt-1 text-xs text-[var(--muted)]">Due {{ optional($task->due_date)->format('Y-m-d') ?: '—' }}</p>
                        <div class="mt-2 text-[10px] uppercase tracking-wider text-[var(--muted)]">Drag to move</div>
                    </article>
                @empty
                    <p class="text-xs text-[var(--muted)]">No tasks.</p>
                @endforelse
            </div>
        </div>
    @endforeach
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const board = document.getElementById('kanban-board');
    if (!board) return;

    const csrfToken = board.dataset.csrf;
    let draggedCard = null;

    const setColumnHighlight = (zone, active) => {
        zone.classList.toggle('border-[var(--accent)]', active);
        zone.classList.toggle('bg-[color-mix(in_srgb,var(--accent)_10%,transparent)]', active);
    };

    board.querySelectorAll('[data-task-id]').forEach((card) => {
        card.addEventListener('dragstart', () => {
            draggedCard = card;
            card.classList.add('opacity-60');
        });

        card.addEventListener('dragend', () => {
            card.classList.remove('opacity-60');
            board.querySelectorAll('[data-dropzone]').forEach((zone) => setColumnHighlight(zone, false));
            draggedCard = null;
        });
    });

    board.querySelectorAll('[data-dropzone]').forEach((zone) => {
        zone.addEventListener('dragover', (event) => {
            event.preventDefault();
            setColumnHighlight(zone, true);
        });

        zone.addEventListener('dragleave', () => {
            setColumnHighlight(zone, false);
        });

        zone.addEventListener('drop', async (event) => {
            event.preventDefault();
            setColumnHighlight(zone, false);

            if (!draggedCard) return;

            const targetStatus = zone.dataset.dropzone;
            const taskId = draggedCard.dataset.taskId;
            const oldStatus = draggedCard.dataset.currentStatus;

            if (!targetStatus || !taskId || targetStatus === oldStatus) return;

            zone.appendChild(draggedCard);
            draggedCard.dataset.currentStatus = targetStatus;

            try {
                const response = await fetch(`{{ url('/'.app()->getLocale().'/admin/tasks') }}/${taskId}/move`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ status: targetStatus }),
                });

                if (!response.ok) {
                    throw new Error('Move failed');
                }
            } catch (error) {
                const oldZone = board.querySelector(`[data-dropzone="${oldStatus}"]`);
                if (oldZone) {
                    oldZone.appendChild(draggedCard);
                    draggedCard.dataset.currentStatus = oldStatus;
                }
                alert('Could not move task. Please try again.');
            }
        });
    });
});
</script>
@endsection
