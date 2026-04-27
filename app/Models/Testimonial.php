<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_title',
        'client_company',
        'avatar_path',
        'is_featured',
        'published',
        'name',
        'company',
        'role',
        'location',
        'quote',
        'image',
        'status',
        'featured',
        'position',
        'published_at',
        'meta',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published' => 'boolean',
        'featured' => 'boolean',
        'published_at' => 'datetime',
        'meta' => 'array',
    ];

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->client_name ?: (string) $this->name;
    }

    public function getDisplayTitleAttribute(): string
    {
        return $this->client_title ?: (string) $this->role;
    }

    public function getDisplayCompanyAttribute(): string
    {
        return $this->client_company ?: (string) $this->company;
    }

    public function getDisplayAvatarAttribute(): ?string
    {
        return $this->avatar_path ?: $this->image;
    }

    public function getDisplayFeaturedAttribute(): bool
    {
        return (bool) ($this->is_featured ?: $this->featured);
    }
}
