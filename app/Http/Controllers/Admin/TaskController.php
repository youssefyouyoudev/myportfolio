<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $tasks = Task::with(['project', 'assignee', 'attachments'])
            ->when($request->filled('project_id'), fn ($query) => $query->where('project_id', $request->integer('project_id')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->orderByRaw("CASE status WHEN 'todo' THEN 1 WHEN 'in_progress' THEN 2 WHEN 'review' THEN 3 WHEN 'done' THEN 4 ELSE 5 END")
            ->orderBy('due_date')
            ->paginate(20)
            ->withQueryString();

        return view('admin.tasks.index', [
            'tasks' => $tasks,
            'projects' => Project::orderBy('title')->get(['id', 'title']),
        ]);
    }

    public function create(Request $request): View
    {
        return view('admin.tasks.form', [
            'task' => new Task([
                'status' => Task::STATUS_TODO,
                'priority' => 'medium',
                'task_type' => Task::TYPE_NORMAL,
                'project_id' => $request->integer('project_id') ?: null,
            ]),
            'projects' => Project::orderBy('title')->get(['id', 'title']),
            'users' => User::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['created_by'] = $request->user()?->id;
        $task = Task::create($this->withRecurrenceMetadata($data));

        $this->storeAttachments($request, $task);

        return redirect()->route('admin.tasks.edit', [$request->route('locale'), $task])->with('status', 'Task created');
    }

    public function edit(Task $task): View
    {
        $task->load(['attachments', 'project', 'assignee']);

        return view('admin.tasks.form', [
            'task' => $task,
            'projects' => Project::orderBy('title')->get(['id', 'title']),
            'users' => User::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $task->update($this->withRecurrenceMetadata($this->validated($request)));

        $this->storeAttachments($request, $task);

        return redirect()->route('admin.tasks.edit', [$request->route('locale'), $task])->with('status', 'Task updated');
    }

    public function destroy(Request $request, Task $task): RedirectResponse
    {
        foreach ($task->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $task->delete();

        return redirect()->route('admin.tasks.index', [$request->route('locale')])->with('status', 'Task removed');
    }

    public function kanban(): View
    {
        $tasks = Task::with(['project', 'assignee'])
            ->orderBy('due_date')
            ->get();

        $columns = [
            Task::STATUS_TODO => 'To do',
            Task::STATUS_IN_PROGRESS => 'In progress',
            Task::STATUS_REVIEW => 'Review',
            Task::STATUS_DONE => 'Done',
        ];

        return view('admin.tasks.kanban', compact('tasks', 'columns'));
    }

    public function gantt(): View
    {
        $tasks = Task::with('project')
            ->whereNotNull('start_date')
            ->whereNotNull('due_date')
            ->orderBy('start_date')
            ->get();

        return view('admin.tasks.gantt', compact('tasks'));
    }

    public function move(Request $request, string $task): RedirectResponse|JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:todo,in_progress,review,done'],
        ]);

        $taskModel = Task::query()->findOrFail($task);

        $taskModel->status = $request->string('status')->toString();
        if ($taskModel->status === Task::STATUS_DONE && ! $taskModel->completed_at) {
            $taskModel->completed_at = now();
        }
        if ($taskModel->status !== Task::STATUS_DONE) {
            $taskModel->completed_at = null;
        }
        $taskModel->save();

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'task_id' => $taskModel->id,
                'status' => $taskModel->status,
            ]);
        }

        return back()->with('status', 'Task moved');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'project_id' => ['nullable', 'exists:projects,id'],
            'assignee_id' => ['nullable', 'exists:users,id'],
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string'],
            'task_type' => ['required', 'in:normal,daily,weekly,monthly'],
            'status' => ['required', 'in:todo,in_progress,review,done'],
            'priority' => ['required', 'in:low,medium,high'],
            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_recurring_template' => ['nullable', 'boolean'],
            'attachments.*' => ['nullable', 'file', 'max:10240'],
        ]);
    }

    private function storeAttachments(Request $request, Task $task): void
    {
        foreach ($request->file('attachments', []) as $file) {
            $path = $file->store('tasks/attachments', 'public');
            $task->attachments()->create([
                'uploaded_by' => $request->user()?->id,
                'name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);
        }
    }

    private function withRecurrenceMetadata(array $data): array
    {
        $isRecurring = in_array($data['task_type'], [Task::TYPE_DAILY, Task::TYPE_WEEKLY, Task::TYPE_MONTHLY], true)
            && (bool) ($data['is_recurring_template'] ?? false);

        $data['is_recurring_template'] = $isRecurring;
        $data['next_occurrence_at'] = $isRecurring
            ? Carbon::parse($data['start_date'] ?? now()->toDateString())->startOfDay()
            : null;

        return $data;
    }
}
