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
        'navigation_status',
        'timestamp',
        'turning_rate',
        'turning_direction',
        'distance',
        'is_inside_geofence'
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

    public function reportGeofences()
    {
        return $this->hasMany(ReportGeofence::class, 'ais_data_position_id');
    }

    // Assuming it's in AisDataPosition model
    public static function isAisOn($vesselId)
    {
        $lastData = self::where('vessel_id', $vesselId)
            ->orderBy('created_at', 'DESC')
            ->first();

        if (!$lastData) {
            // No data available, consider AIS as off
            return false;
        }

        $currentTime = now();
        $lastDataTime = $lastData->created_at;

        // Calculate the difference in minutes
        $minutesDiff = $currentTime->diffInMinutes($lastDataTime);

        // If the difference is greater than 5 minutes, AIS is considered off
        return $minutesDiff <= 5;
    }
}
