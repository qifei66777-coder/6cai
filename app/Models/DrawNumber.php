<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrawNumber extends Model
{
    protected $fillable = ['draw_result_id', 'number', 'color', 'label', 'sort_order'];

    public function drawResult()
    {
        return $this->belongsTo(DrawResult::class);
    }

    public function getColorClass(): string
    {
        return match($this->color) {
            'red'   => 'bg-red-500',
            'blue'  => 'bg-blue-500',
            'green' => 'bg-green-500',
            default => 'bg-gray-400',
        };
    }
}
