<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadarData extends Model
{
    use HasFactory;

    protected $table = 'radar_datas';

    protected $fillable = [
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

    public function sensorData()
    {
        return $this->belongsTo(SensorData::class);
    }
}