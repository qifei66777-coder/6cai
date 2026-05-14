<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['title', 'image_path', 'link_url', 'sort_order', 'is_enabled'];
    protected $casts = ['is_enabled' => 'boolean'];
}
