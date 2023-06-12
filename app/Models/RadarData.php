<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadarData extends Model
{
    use HasFactory;

    protected $fillable = [
        'sensor_data_id',
        'target_id',
        'latitude',
        'longitude',
        'altitude',
        'speed',
        'heading',
        'course',
        'range',
        'bearing',
        'timestamp',
    ];
}
