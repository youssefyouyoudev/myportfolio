<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Service extends Model
{
    use HasFactory;
    use HasLocalizedContent;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'price_from',
        'featured_image',
        'cta_url',
        'status',
        'position',
        'translations',
        'features',
        'meta',
        'category_id',
        'published_at',
    ];

    protected $casts = [
        'translations' => 'array',
        'features' => 'array',
        'meta' => 'array',
        'published_at' => 'datetime',
        'price_from' => 'decimal:2',
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
}
