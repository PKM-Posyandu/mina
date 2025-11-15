<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosyanduSchedule extends Model
{
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'is_published',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_published' => 'boolean',
    ];
}
