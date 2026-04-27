<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Project extends Model
{
    use HasFactory;
    use HasLocalizedContent;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'description',
        'status',
        'featured',
        'live_url',
        'client_name',
        'client_industry',
        'result_headline',
        'is_concept',
        'is_nda',
        'built_at',
        'screenshot_path',
        'screenshot_webp_path',
        'context',
        'problem_long',
        'solution_long',
        'outcome_long',
        'result_1_label',
        'result_1_value',
        'result_2_label',
        'result_2_value',
        'result_3_label',
        'result_3_value',
        'metric_one_label',
        'metric_one_value',
        'metric_two_label',
        'metric_two_value',
        'metric_three_label',
        'metric_three_value',
        'repo_url',
        'hero_image',
        'stack',
        'translations',
        'meta',
        'published_at',
        'category_id',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'is_concept' => 'boolean',
        'is_nda' => 'boolean',
        'built_at' => 'date',
        'stack' => 'array',
        'translations' => 'array',
        'meta' => 'array',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function seoMeta(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    public function screenshots(): HasMany
    {
        return $this->hasMany(ProjectScreenshot::class)->orderBy('sort_order');
    }

    public function files(): HasMany
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
