<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrigateObjectTrackingEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'camera',
        'event_type',
        'before_state',
        'after_state'
    ];

    protected $casts = [
        'before_state' => 'array',
        'after_state' => 'array'
    ];
}
