<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'cover_image', 'excerpt', 'content',
        'is_published', 'is_pinned', 'tag', 'sort_order', 'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_pinned' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Post $model) {
            if (!$model->slug && $model->title) {
                $model->slug = 'post-' . $model->id . '-' . time();
            }
            if ($model->is_published && !$model->published_at) {
                $model->published_at = now();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
