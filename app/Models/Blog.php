<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'is_deleted',
        'published_at'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_deleted' => 'boolean',
        'tags' => 'array',
        'published_at' => 'datetime'
    ];

    protected $appends = [
        'featured_image_url',
        'reading_time',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(BlogReaction::class);
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (! $this->featured_image) {
            return null;
        }

        if (str_starts_with($this->featured_image, 'http://') || str_starts_with($this->featured_image, 'https://')) {
            return $this->featured_image;
        }

        return asset('storage/' . ltrim($this->featured_image, '/'));
    }

    public function getReadingTimeAttribute(): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags($this->content ?? '')) / 180));
    }
}
