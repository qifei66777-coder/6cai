<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    protected $fillable = ['section_key', 'title', 'is_enabled', 'sort_order', 'display_limit'];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];
}
