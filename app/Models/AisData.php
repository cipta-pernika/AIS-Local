<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AisData extends Model
{
    use HasFactory;

    protected $fillable = [
        'sensor_data_id',
        'vessel_name',
        'vessel_type',
        'mmsi',
        'latitude',
        'longitude',
        'speed',
        'course',
        'navigation_status',
        'timestamp',
    ];
}
