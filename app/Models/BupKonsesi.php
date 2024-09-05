<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BupKonsesi extends Model
{
    public $table = 'bup_konsesis';

    public $fillable = [
        'bup',
        'bruto',
        'besaran_konsesi',
        'pendapatan_konsesi',
        'month',
        'year',
    ];

    protected $casts = [
        'bup' => 'string',
    ];

    public static array $rules = [
        'bup' => 'nullable|string|max:255',
        'bruto' => 'required',
        'besaran_konsesi' => 'required',
        'pendapatan_konsesi' => 'required',
        'month' => 'required',
        'year' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    
}
