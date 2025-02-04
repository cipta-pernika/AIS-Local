<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Muatan
 *
 * @property $id
 * @property $mmsi
 * @property $curah_kering_food_grain
 * @property $curah_kering_non_food_grain
 * @property $general_cargo
 * @property $petikemas_20
 * @property $petikemas_40
 * @property $curah_cair
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Muatan extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['mmsi', 'curah_kering_food_grain', 'curah_kering_non_food_grain', 'general_cargo', 'petikemas_20', 'petikemas_40', 'curah_cair'];

    public function aisDataVessel()
    {
        return $this->belongsTo(AisDataVessel::class, 'mmsi', 'mmsi');
    }
}
