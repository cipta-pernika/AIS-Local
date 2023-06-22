<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsbDataPosition extends Model
{
    use HasFactory;

    protected $table = 'adsb_data_positions';

    protected $fillable = [
        'sensor_data_id',
        'aircraft_id',
        'flight_id',
        'latitude',
        'longitude',
        'altitude',
        'ground_speed',
        'vertical_rate',
        'track',
        'timestamp',
        'transmission_type',
    ];

    public function sensorData()
    {
        return $this->belongsTo(SensorData::class, 'sensor_data_id');
    }

    public function aircraft()
    {
        return $this->belongsTo(AdsbDataAircraft::class, 'aircraft_id');
    }
}
