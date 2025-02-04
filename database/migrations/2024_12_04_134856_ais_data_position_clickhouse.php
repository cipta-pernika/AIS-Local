<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends \PhpClickHouseLaravel\Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // static::write('
        //     CREATE TABLE ais_data_position_clickhouse (
        //         id UInt64,
        //         sensor_data_id UInt64,
        //         vessel_id UInt64,
        //         latitude Decimal(10, 7),
        //         longitude Decimal(10, 7),
        //         speed Decimal(8, 2),
        //         course Nullable(UInt16),
        //         heading Nullable(UInt16),
        //         navigation_status Nullable(String),
        //         turning_rate Nullable(Int32),
        //         turning_direction Nullable(Int32),
        //         timestamp DateTime,
        //         distance Nullable(Decimal(8, 2)),
        //         is_inside_geofence Int8 DEFAULT 0,
        //         is_geofence Int8 DEFAULT 0,
        //         created_at DateTime
        //     )
        //     ENGINE = MergeTree()
        //     ORDER BY (id)
        // ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // static::write('DROP TABLE ais_data_position_clickhouse');
    }
};
