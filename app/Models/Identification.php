<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Identification extends Model
{
    public $table = 'identifications';

    public $fillable = [
        'name',
        'desc'
    ];

    protected $casts = [
        'name' => 'string',
        'desc' => 'string'
    ];

    public static array $rules = [
        'name' => 'nullable|string|max:255',
        'desc' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
