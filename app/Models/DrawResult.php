<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrawResult extends Model
{
    protected $fillable = [
        'type', 'issue_number', 'draw_date', 'draw_time', 'weekday', 'status',
        'special_number', 'special_color', 'special_label',
        'video_file', 'video_url', 'history_url',
        'is_published', 'is_home_featured',
    ];

    protected $casts = [
        'draw_date' => 'date',
        'is_published' => 'boolean',
        'is_home_featured' => 'boolean',
    ];

    public function drawNumbers()
    {
        return $this->hasMany(DrawNumber::class)->orderBy('sort_order');
    }

    public function getTypeLabel(): string
    {
        return DrawSchedule::where('type', $this->type)->value('type_label') ?? $this->type;
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'pending' => '待开奖',
            'drawing' => '正在开奖',
            'completed' => '已开奖',
            default => $this->status,
        };
    }

    public function getWeekdayLabel(): string
    {
        $map = [1=>'周一',2=>'周二',3=>'周三',4=>'周四',5=>'周五',6=>'周六',7=>'周日'];
        $wd = $this->weekday ?? ($this->draw_date ? $this->draw_date->dayOfWeekIso : null);
        return $map[$wd] ?? '';
    }

    public function getDrawDatetimeAttribute(): ?string
    {
        if (!$this->draw_date || !$this->draw_time) return null;
        return $this->draw_date->format('Y-m-d') . ' ' . $this->draw_time;
    }

    protected static function booted(): void
    {
        static::saving(function (DrawResult $model) {
            if ($model->draw_date) {
                $date = is_string($model->draw_date)
                    ? \Carbon\Carbon::parse($model->draw_date)
                    : $model->draw_date;
                $model->weekday = $date->dayOfWeekIso;
            }
        });

        static::saved(function (DrawResult $model) {
            if ($model->is_home_featured) {
                static::where('type', $model->type)
                    ->where('id', '!=', $model->id)
                    ->update(['is_home_featured' => false]);
            }
        });
    }
}
