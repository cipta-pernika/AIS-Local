<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PkkHistory extends Model
{
    public $table = 'pkk_histories';

    public $fillable = [
        'ais_data_vessel_id',
        'no_pkk'
    ];

    protected $casts = [
        'no_pkk' => 'string'
    ];

    public static array $rules = [
        'ais_data_vessel_id' => 'nullable',
        'no_pkk' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public function aisDataVessel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AisDataVessel::class, 'ais_data_vessel_id');
    }
}
