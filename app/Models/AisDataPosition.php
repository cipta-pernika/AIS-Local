<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AisDataPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'sensor_data_id',
        'vessel_id',
        'port_id',
        'latitude',
        'longitude',
        'speed',
        'course',
        'heading',
        'status',
        'timestamp',
    ];

    public function sensorData()
    {
        return $this->belongsTo(SensorData::class);
    }

    public function vessel()
    {
        return $this->belongsTo(AisDataVessel::class);
    }

    public function port()
    {
        return $this->belongsTo(Port::class);
    }
}
