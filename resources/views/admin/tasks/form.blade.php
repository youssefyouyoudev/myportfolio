@extends('layouts.admin')

@section('content')
<h1 class="mb-4 text-2xl font-semibold text-[var(--text-strong)]">{{ $task->exists ? 'Edit task' : 'New task' }}</h1>
<form method="post" enctype="multipart/form-data" action="{{ $task->exists ? route('admin.tasks.update', [app()->getLocale(), $task]) : route('admin.tasks.store', app()->getLocale()) }}" class="surface space-y-4 p-6">
    @csrf
    @if($task->exists)
        @method('PUT')
    @endif

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Title</label>
            <input name="title" value="{{ old('title', $task->title) }}" class="input-ghost mt-2 w-full" required>
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Project</label>
            <select name="project_id" class="input-ghost mt-2 w-full">
                <option value="">General</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" @selected(old('project_id', $task->project_id) == $project->id)>{{ $project->title }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label class="text-sm font-semibold text-[var(--muted)]">Description</label>
        <textarea name="description" rows="5" class="input-ghost mt-2 w-full">{{ old('description', $task->description) }}</textarea>
    </div>

    <div class="grid gap-4 md:grid-cols-4">
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Task type</label>
            <select name="task_type" class="input-ghost mt-2 w-full">
                <option value="normal" @selected(old('task_type', $task->task_type) === 'normal')>Normal</option>
                <option value="daily" @selected(old('task_type', $task->task_type) === 'daily')>Daily</option>
                <option value="weekly" @selected(old('task_type', $task->task_type) === 'weekly')>Weekly</option>
                <option value="monthly" @selected(old('task_type', $task->task_type) === 'monthly')>Monthly</option>
            </select>
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Status</label>
            <select name="status" class="input-ghost mt-2 w-full">
                <option value="todo" @selected(old('status', $task->status) === 'todo')>To do</option>
                <option value="in_progress" @selected(old('status', $task->status) === 'in_progress')>In progress</option>
                <option value="review" @selected(old('status', $task->status) === 'review')>Review</option>
                <option value="done" @selected(old('status', $task->status) === 'done')>Done</option>
            </select>
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Priority</label>
            <select name="priority" class="input-ghost mt-2 w-full">
                <option value="low" @selected(old('priority', $task->priority) === 'low')>Low</option>
                <option value="medium" @selected(old('priority', $task->priority) === 'medium')>Medium</option>
                <option value="high" @selected(old('priority', $task->priority) === 'high')>High</option>
            </select>
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Assignee</label>
            <select name="assignee_id" class="input-ghost mt-2 w-full">
                <option value="">Unassigned</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected(old('assignee_id', $task->assignee_id) == $user->id)>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Start date</label>
            <input type="date" name="start_date" value="{{ old('start_date', optional($task->start_date)->toDateString()) }}" class="input-ghost mt-2 w-full">
        </div>
        <div>
            <label class="text-sm font-semibold text-[var(--muted)]">Due date</label>
            <input type="date" name="due_date" value="{{ old('due_date', optional($task->due_date)->toDateString()) }}" class="input-ghost mt-2 w-full">
        </div>
        <div class="mt-7 flex items-center gap-2">
            <input type="hidden" name="is_recurring_template" value="0">
            <input type="checkbox" name="is_recurring_template" value="1" class="h-4 w-4 accent-[var(--accent)]" @checked(old('is_recurring_template', $task->is_recurring_template))>
            <label class="text-sm font-semibold text-[var(--muted)]">Recurring template</label>
        </div>
    </div>

    <div>
        <label class="text-sm font-semibold text-[var(--muted)]">Attachments</label>
        <input type="file" name="attachments[]" multiple class="input-ghost mt-2 w-full">
        @if($task->exists && $task->attachments->isNotEmpty())
            <ul class="mt-3 space-y-2 text-xs text-[var(--muted)]">
                @foreach($task->attachments as $attachment)
                    <li>• {{ $attachment->name }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <button class="btn-primary" type="submit">Save</button>
</form>
@endsection
