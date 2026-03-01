<?php

namespace App\Jobs;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateRecurringTasksJob implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $templates = Task::query()
            ->where('is_recurring_template', true)
            ->whereIn('task_type', [Task::TYPE_DAILY, Task::TYPE_WEEKLY, Task::TYPE_MONTHLY])
            ->whereNotNull('next_occurrence_at')
            ->where('next_occurrence_at', '<=', now())
            ->get();

        foreach ($templates as $template) {
            $occurrenceDate = Carbon::parse($template->next_occurrence_at);

            Task::create([
                'project_id' => $template->project_id,
                'parent_task_id' => $template->id,
                'assignee_id' => $template->assignee_id,
                'created_by' => $template->created_by,
                'title' => $template->title,
                'description' => $template->description,
                'task_type' => Task::TYPE_NORMAL,
                'status' => Task::STATUS_TODO,
                'priority' => $template->priority,
                'start_date' => $occurrenceDate->toDateString(),
                'due_date' => $occurrenceDate->toDateString(),
            ]);

            $template->next_occurrence_at = match ($template->task_type) {
                Task::TYPE_DAILY => $occurrenceDate->addDay(),
                Task::TYPE_WEEKLY => $occurrenceDate->addWeek(),
                Task::TYPE_MONTHLY => $occurrenceDate->addMonth(),
                default => null,
            };
            $template->save();
        }
    }
}
