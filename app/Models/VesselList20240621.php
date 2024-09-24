<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class VesselList20240621
 *
 * @property $uuid
 * @property $mmsi
 * @property $imo
 * @property $eni
 * @property $name
 * @property $name_ais
 * @property $country
 * @property $callsign
 * @property $vessel_type
 * @property $vessel_type_specific
 * @property $gross_tonnage
 * @property $deadweight
 * @property $teu
 * @property $length
 * @property $breadth
 * @property $home_port
 * @property $year_build
 * @property $status
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class VesselList20240621 extends Model
{
    use SoftDeletes;

    protected $perPage = 20;

    protected $table = 'vessel_list_20240621';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['mmsi', 'imo', 'eni', 'name', 'name_ais', 'country', 'callsign', 'vessel_type', 'vessel_type_specific', 'gross_tonnage', 'deadweight', 'teu', 'length', 'breadth', 'home_port', 'year_build', 'status'];


}
