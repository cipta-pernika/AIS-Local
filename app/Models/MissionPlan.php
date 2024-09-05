<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionPlan extends Model
{
    public $table = 'mission_plans';

    public $fillable = [
        'asset_id',
        'name',
        'ETD',
        'ATD',
        'ETA',
        'ATA',
        'route_plans',
        'captain',
        'muatan',
        'note',
        'status'
    ];

    protected $casts = [
        'name' => 'string',
        'ETD' => 'datetime',
        'ATD' => 'datetime',
        'ETA' => 'datetime',
        'ATA' => 'datetime',
        'route_plans' => 'string',
        'captain' => 'string',
        'muatan' => 'string',
        'note' => 'string',
        'status' => 'boolean'
    ];

    public static array $rules = [
        'asset_id' => 'required',
        'name' => 'nullable|string|max:255',
        'ETD' => 'nullable',
        'ATD' => 'nullable',
        'ETA' => 'nullable',
        'ATA' => 'nullable',
        'route_plans' => 'nullable|string|max:65535',
        'captain' => 'nullable|string|max:255',
        'muatan' => 'nullable|string|max:255',
        'note' => 'nullable|string|max:65535',
        'status' => 'nullable|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
