<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PkkAssignHistory extends Model
{
    public $table = 'pkk_assign_histories';

    public $fillable = [
        'ais_data_vessel_id',
        'no_pkk',
        'no_pkk_assign',
        'nama_perusahaan'
    ];

    protected $casts = [
        'no_pkk' => 'string',
        'no_pkk_assign' => 'string',
        'nama_perusahaan' => 'string'
    ];

    public static array $rules = [
        'ais_data_vessel_id' => 'nullable',
        'no_pkk' => 'nullable|string|max:255',
        'no_pkk_assign' => 'nullable|string|max:255',
        'nama_perusahaan' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public function aisDataVessel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AisDataVessel::class, 'ais_data_vessel_id');
    }
}
