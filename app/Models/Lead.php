<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'company',
        'budget',
        'message',
        'locale',
        'source',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}
