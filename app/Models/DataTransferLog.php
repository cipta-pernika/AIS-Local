<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTransferLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'timestamp',
        'response_code',
        'response_time',
        'additional_info',
    ];
}
