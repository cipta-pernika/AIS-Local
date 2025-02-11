<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;

    protected $table = 'sensor_datas';

    protected $fillable = [
        'sensor_id',
        'payload',
        'timestamp',
    ];

    // Relationship with AisDataPosition
    public function position()
    {
        return $this->hasOne(AisDataPosition::class);
    }

    // Relationship with Sensor
    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

    public function radar()
    {
        return $this->hasOne(Radar::class);
    }
}
