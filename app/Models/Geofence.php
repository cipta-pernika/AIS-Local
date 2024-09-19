<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Geofence
 *
 * @property $id
 * @property $user_id
 * @property $geofence_type_id
 * @property $pelabuhan_id
 * @property $terminal_id
 * @property $location_id
 * @property $geofence_name
 * @property $type
 * @property $type_geo
 * @property $radius
 * @property $geometry
 * @property $isMaster
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property BongkarMuatTerlambat[] $bongkarMuatTerlambats
 * @property DataMandiriKapal[] $dataMandiriKapals
 * @property EventTracking[] $eventTrackings
 * @property GeofenceBinding[] $geofenceBindings
 * @property PanduTerlambat[] $panduTerlambats
 * @property PanduTidakTerjadwal[] $panduTidakTerjadwals
 * @property ReportGeofenceBongkarMuat[] $reportGeofenceBongkarMuats
 * @property ReportGeofencePandu[] $reportGeofencePanduses
 * @property ReportGeofence[] $reportGeofences
 * @property TidakTerjadwal[] $tidakTerjadwals
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Geofence extends Model
{
    use SoftDeletes;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'geofence_type_id', 'pelabuhan_id', 'terminal_id', 'location_id', 'geofence_name', 'type', 'type_geo', 'radius', 'geometry', 'isMaster'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bongkarMuatTerlambats()
    {
        return $this->hasMany(\App\Models\BongkarMuatTerlambat::class, 'id', 'geofence_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataMandiriKapals()
    {
        return $this->hasMany(\App\Models\DataMandiriKapal::class, 'id', 'geofence_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventTrackings()
    {
        return $this->hasMany(\App\Models\EventTracking::class, 'id', 'geofence_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function geofenceBindings()
    {
        return $this->hasMany(\App\Models\GeofenceBinding::class, 'id', 'geofence_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function panduTerlambats()
    {
        return $this->hasMany(\App\Models\PanduTerlambat::class, 'id', 'geofence_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function panduTidakTerjadwals()
    {
        return $this->hasMany(\App\Models\PanduTidakTerjadwal::class, 'id', 'geofence_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reportGeofenceBongkarMuats()
    {
        return $this->hasMany(\App\Models\ReportGeofenceBongkarMuat::class, 'id', 'geofence_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reportGeofencePanduses()
    {
        return $this->hasMany(\App\Models\ReportGeofencePandu::class, 'id', 'geofence_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reportGeofences()
    {
        return $this->hasMany(\App\Models\ReportGeofence::class, 'id', 'geofence_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tidakTerjadwals()
    {
        return $this->hasMany(\App\Models\TidakTerjadwal::class, 'id', 'geofence_id');
    }
    
}
