<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpClickHouseLaravel\BaseModel;

class AisDataPositionClickHouse extends BaseModel
{
    use HasFactory;

    protected $table = 'ais_data_position_clickhouse';
}
