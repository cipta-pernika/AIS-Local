<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    public $table = 'certificates';

    public $fillable = [
        'ais_data_vessel_id',
        'sertifikat',
        'tgl_terbit',
        'tgl_expired'
    ];

    protected $casts = [
        'sertifikat' => 'string',
        'tgl_terbit' => 'date',
        'tgl_expired' => 'date'
    ];

    public static array $rules = [
        'ais_data_vessel_id' => 'required',
        'sertifikat' => 'required|string|max:255',
        'tgl_terbit' => 'required',
        'tgl_expired' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function aisDataVessel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AisDataVessel::class, 'ais_data_vessel_id');
    }
}
