<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'meta_title',
        'meta_description',
        'meta_image',
        'og_title',
        'og_description',
        'canonical',
        'locale',
        'og_type',
        'schema',
        'meta',
    ];

    protected $casts = [
        'schema' => 'array',
        'meta' => 'array',
    ];

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
