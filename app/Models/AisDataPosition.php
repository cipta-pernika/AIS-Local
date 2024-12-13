<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AisDataPosition
 *
 * @property $id
 * @property $sensor_data_id
 * @property $vessel_id
 * @property $latitude
 * @property $longitude
 * @property $speed
 * @property $course
 * @property $heading
 * @property $navigation_status
 * @property $turning_rate
 * @property $turning_direction
 * @property $timestamp
 * @property $distance
 * @property $is_inside_geofence
 * @property $is_geofence
 * @property $created_at
 * @property $updated_at
 *
 * @property SensorData $sensorData
 * @property AisDataVessel $aisDataVessel
 * @property AisDataAnomaly[] $aisDataAnomalies
 * @property BongkarMuatTerlambat[] $bongkarMuatTerlambats
 * @property DataMandiriKapal[] $dataMandiriKapals
 * @property EventTracking[] $eventTrackings
 * @property PanduTerlambat[] $panduTerlambats
 * @property PanduTidakTerjadwal[] $panduTidakTerjadwals
 * @property ReportGeofenceBongkarMuat[] $reportGeofenceBongkarMuats
 * @property ReportGeofencePandu[] $reportGeofencePanduses
 * @property ReportGeofence[] $reportGeofences
 * @property TidakTerjadwal[] $tidakTerjadwals
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class AisDataPosition extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['sensor_data_id', 'vessel_id', 'latitude', 'longitude', 'speed', 'course', 'heading', 'navigation_status', 'turning_rate', 'turning_direction', 'timestamp', 'distance', 'is_inside_geofence', 'is_geofence'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sensorData()
    {
        return $this->belongsTo(\App\Models\SensorData::class, 'sensor_data_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aisDataVessel()
    {
        return $this->belongsTo(\App\Models\AisDataVessel::class, 'vessel_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aisDataAnomalies()
    {
        return $this->hasMany(\App\Models\AisDataAnomaly::class, 'id', 'ais_data_position_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bongkarMuatTerlambats()
    {
        return $this->hasMany(\App\Models\BongkarMuatTerlambat::class, 'id', 'ais_data_position_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataMandiriKapals()
    {
        return $this->hasMany(\App\Models\DataMandiriKapal::class, 'id', 'ais_data_position_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventTrackings()
    {
        return $this->hasMany(\App\Models\EventTracking::class, 'id', 'ais_data_position_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function panduTerlambats()
    {
        return $this->hasMany(\App\Models\PanduTerlambat::class, 'id', 'ais_data_position_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function panduTidakTerjadwals()
    {
        return $this->hasMany(\App\Models\PanduTidakTerjadwal::class, 'id', 'ais_data_position_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reportGeofenceBongkarMuats()
    {
        return $this->hasMany(\App\Models\ReportGeofenceBongkarMuat::class, 'id', 'ais_data_position_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reportGeofencePanduses()
    {
        return $this->hasMany(\App\Models\ReportGeofencePandu::class, 'id', 'ais_data_position_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reportGeofences()
    {
        // return $this->hasMany(\App\Models\ReportGeofence::class, 'id', 'ais_data_position_id');
        return $this->hasMany(\App\Models\ReportGeofence::class, 'ais_data_position_id','id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tidakTerjadwals()
    {
        return $this->hasMany(\App\Models\TidakTerjadwal::class, 'id', 'ais_data_position_id');
    }
    
}
