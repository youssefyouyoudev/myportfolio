<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    use HasLocalizedContent;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'translations',
    ];

    protected $casts = [
        'translations' => 'array',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
