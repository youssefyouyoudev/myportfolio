<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    public const TYPE_NORMAL = 'normal';
    public const TYPE_DAILY = 'daily';
    public const TYPE_WEEKLY = 'weekly';
    public const TYPE_MONTHLY = 'monthly';

    public const STATUS_TODO = 'todo';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_REVIEW = 'review';
    public const STATUS_DONE = 'done';

    protected $fillable = [
        'project_id',
        'parent_task_id',
        'assignee_id',
        'created_by',
        'title',
        'description',
        'task_type',
        'status',
        'priority',
        'start_date',
        'due_date',
        'completed_at',
        'is_recurring_template',
        'next_occurrence_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'completed_at' => 'datetime',
        'is_recurring_template' => 'boolean',
        'next_occurrence_at' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parentTask(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_task_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_task_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(TaskAttachment::class);
    }
}
