<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoLink extends Model
{
    protected $fillable = ['title', 'description', 'url', 'button_text', 'sort_order', 'is_enabled'];
    protected $casts = ['is_enabled' => 'boolean'];
}
