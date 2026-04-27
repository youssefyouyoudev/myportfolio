<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Post extends Model
{
    use HasFactory;
    use HasLocalizedContent;

    protected $appends = ['reading_time'];

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'status',
        'featured',
        'cover_image',
        'translations',
        'meta',
        'published_at',
        'category_id',
    ];

    protected $casts = [
        'featured' => 'boolean',
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

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getReadingTimeAttribute(): int
    {
        $body = strip_tags((string) $this->body);
        $wordCount = str_word_count($body);

        return max(1, (int) ceil($wordCount / 200));
    }
}
