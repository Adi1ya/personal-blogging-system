<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'featured_image',
        'category',
        'tags',
        'is_published',
        'published_at'
    ];

    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime'
    ];
}
