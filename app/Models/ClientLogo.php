<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLogo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image_path',
        'website_url',
        'alt_text',
        'is_featured',
        'verified',
        'permission_given',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'verified' => 'boolean',
        'permission_given' => 'boolean',
    ];
}
