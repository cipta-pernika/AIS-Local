<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapSetting extends Model
{
    public $table = 'map_settings';

    public $fillable = [
        'user_id',
        'distance_unit',
        'speed_unit',
        'breadcrumb',
        'breadcrumb_point',
        'time_zone',
        'coordinate_format'
    ];

    protected $casts = [
        'distance_unit' => 'string',
        'speed_unit' => 'string',
        'breadcrumb' => 'string',
        'breadcrumb_point' => 'string',
        'time_zone' => 'string',
        'coordinate_format' => 'string'
    ];

    public static array $rules = [
        'user_id' => 'required',
        'distance_unit' => 'nullable|string|max:255',
        'speed_unit' => 'nullable|string|max:255',
        'breadcrumb' => 'nullable|string',
        'breadcrumb_point' => 'nullable|string',
        'time_zone' => 'nullable|string|max:255',
        'coordinate_format' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
