<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrawSchedule extends Model
{
    protected $fillable = ['type', 'type_label', 'default_weekdays', 'default_time'];
}
