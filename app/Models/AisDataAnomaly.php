<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AisDataAnomaly extends Model
{
    public $table = 'ais_data_anomalies';

    public $fillable = [
        'ais_data_position_id',
        'anomaly_type',
        'anomaly_description'
    ];

    protected $casts = [
        'anomaly_type' => 'string',
        'anomaly_description' => 'string'
    ];

    public static array $rules = [
        'ais_data_position_id' => 'required',
        'anomaly_type' => 'required|string|max:255',
        'anomaly_description' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function aisDataPosition(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AisDataPosition::class, 'ais_data_position_id');
    }
}
