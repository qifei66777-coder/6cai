<?php

namespace App\Models;

use App\Observers\GalleryImageObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(GalleryImageObserver::class)]
class GalleryImage extends Model
{
    protected $fillable = ['title', 'description', 'image_path', 'link_url', 'is_visible', 'sort_order'];

    protected $casts = [
        'is_visible' => 'boolean',
    ];
}
