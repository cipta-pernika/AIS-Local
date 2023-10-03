<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsbData extends Model
{
    use HasFactory;

    protected $fillable = [
        'sensor_data_id',
        'aircraft_id',
        'latitude',
        'longitude',
        'altitude',
        'ground_speed',
        'vertical_rate',
        'track',
        'heading',
        'timestamp',
    ];

    public function aircraft()
    {
        return $this->belongsTo(AdsbDataAircraft::class, 'aircraft_id');
    }
}