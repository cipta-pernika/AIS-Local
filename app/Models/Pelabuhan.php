<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelabuhan extends Model
{
    public $table = 'pelabuhans';

    public $fillable = [
        'name',
        'un_locode',
        'latitude',
        'longitude',
        'address'
    ];

    protected $casts = [
        'name' => 'string',
        'un_locode' => 'string',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'address' => 'string'
    ];

    public static array $rules = [
        'name' => 'required|string|max:255',
        'un_locode' => 'required|string|max:255',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'address' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
