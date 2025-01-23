<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnomalyVariable extends Model
{
    public $table = 'anomaly_variables';

    public $fillable = [
        'name',
        'description',
        'unit',
        'type',
        'value'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'unit' => 'string',
        'type' => 'string',
        'value' => 'string'
    ];

    public static array $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
        'unit' => 'nullable|string|max:255',
        'type' => 'nullable|string|max:255',
        'value' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
