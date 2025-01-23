<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public $table = 'activity_log';

    public $fillable = [
        'log_name',
        'description',
        'subject_type',
        'event',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
        'batch_uuid'
    ];

    protected $casts = [
        'log_name' => 'string',
        'description' => 'string',
        'subject_type' => 'string',
        'event' => 'string',
        'causer_type' => 'string',
        'properties' => 'string',
        'batch_uuid' => 'string'
    ];

    public static array $rules = [
        'log_name' => 'nullable|string|max:255',
        'description' => 'required|string|max:65535',
        'subject_type' => 'nullable|string|max:255',
        'event' => 'nullable|string|max:255',
        'subject_id' => 'nullable',
        'causer_type' => 'nullable|string|max:255',
        'causer_id' => 'nullable',
        'properties' => 'nullable|string',
        'batch_uuid' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
