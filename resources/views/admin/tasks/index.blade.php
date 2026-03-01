@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <h1 class="text-2xl font-semibold text-[var(--text-strong)]">Tasks</h1>
    <div class="flex gap-2">
        <a class="btn-primary text-sm" href="{{ route('admin.tasks.kanban') }}">Kanban</a>
        <a class="btn-primary text-sm" href="{{ route('admin.tasks.gantt') }}">Gantt</a>
        <a class="btn-primary text-sm" href="{{ route('admin.tasks.create') }}">New task</a>
    </div>
</div>

<form method="get" class="surface mb-4 grid gap-3 p-4 md:grid-cols-3">
    <div>
        <label class="text-xs font-semibold uppercase tracking-wider text-[var(--muted)]">Project</label>
        <select name="project_id" class="input-ghost mt-2 w-full">
            <option value="">All</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}" @selected(request('project_id') == $project->id)>{{ $project->title }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="text-xs font-semibold uppercase tracking-wider text-[var(--muted)]">Status</label>
        <select name="status" class="input-ghost mt-2 w-full">
            <option value="">All</option>
            <option value="todo" @selected(request('status') === 'todo')>To do</option>
            <option value="in_progress" @selected(request('status') === 'in_progress')>In progress</option>
            <option value="review" @selected(request('status') === 'review')>Review</option>
            <option value="done" @selected(request('status') === 'done')>Done</option>
        </select>
    </div>
    <div class="flex items-end">
        <button class="btn-primary text-sm" type="submit">Filter</button>
    </div>
</form>

<div class="surface overflow-hidden">
    <table class="admin-table text-sm">
        <thead>
            <tr>
                <th>Task</th>
                <th>Project</th>
                <th>Type</th>
                <th>Status</th>
                <th>Due</th>
                <th>Files</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td class="text-[var(--muted)]">{{ $task->project?->title ?? 'General' }}</td>
                    <td class="text-[var(--muted)]">{{ strtoupper($task->task_type) }}</td>
                    <td>{{ strtoupper(str_replace('_', ' ', $task->status)) }}</td>
                    <td class="text-[var(--muted)]">{{ optional($task->due_date)->format('Y-m-d') }}</td>
                    <td class="text-[var(--muted)]">{{ $task->attachments->count() }}</td>
                    <td class="space-x-3 text-right">
                        <a class="font-semibold text-[var(--accent-2)] hover:opacity-80" href="{{ route('admin.tasks.edit', [app()->getLocale(), $task]) }}">Edit</a>
                        <form method="post" action="{{ route('admin.tasks.destroy', [app()->getLocale(), $task]) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn-danger text-sm" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-[var(--muted)]">No tasks found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4 text-sm text-[var(--muted)]">{{ $tasks->links() }}</div>
@endsection
