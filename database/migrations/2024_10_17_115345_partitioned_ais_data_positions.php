<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
// use Brokenice\LaravelMysqlPartition\Models\Partition;
// use Brokenice\LaravelMysqlPartition\Schema\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // if (DB::getDriverName() == 'pgsql') {
        //     // PostgreSQL requires partitioning to be defined during table creation
        //     DB::statement('CREATE TABLE partitioned_ais_data_positions (
        //         id BIGINT,
        //         sensor_data_id BIGINT,
        //         vessel_id BIGINT,
        //         latitude DECIMAL(10,7),
        //         longitude DECIMAL(10,7),
        //         speed DECIMAL(8,2),
        //         course SMALLINT,
        //         heading SMALLINT,
        //         navigation_status VARCHAR(255),
        //         turning_rate INTEGER,
        //         turning_direction INTEGER,
        //         timestamp TIMESTAMP,
        //         distance DECIMAL(8,2),
        //         is_inside_geofence SMALLINT DEFAULT 0,
        //         is_geofence SMALLINT DEFAULT 0,
        //         created_at TIMESTAMP,
        //         updated_at TIMESTAMP,
        //         PRIMARY KEY (id, timestamp)
        //     ) PARTITION BY RANGE (timestamp)');

        //     // Create indexes
        //     DB::statement('CREATE INDEX idx_sensor_data_id ON partitioned_ais_data_positions(sensor_data_id)');
        //     DB::statement('CREATE INDEX idx_vessel_id ON partitioned_ais_data_positions(vessel_id)');
        //     DB::statement('CREATE INDEX idx_timestamp ON partitioned_ais_data_positions(timestamp)');
        //     DB::statement('CREATE INDEX idx_created_at ON partitioned_ais_data_positions(created_at)');
            
        //     // Create partitions
        //     $currentYear = date('Y');
        //     for ($year = $currentYear; $year <= $currentYear + 5; $year++) {
        //         $startDate = "{$year}-01-01";
        //         $endDate = ($year + 1) . "-01-01";
        //         DB::statement("CREATE TABLE partitioned_ais_data_positions_{$year} PARTITION OF partitioned_ais_data_positions 
        //             FOR VALUES FROM ('$startDate') TO ('$endDate')");
        //     }
        // } else {
        //     Schema::create('partitioned_ais_data_positions', function (Blueprint $table) {
        //         $table->bigInteger('id');
        //         $table->primary(['id', 'timestamp']);
        //         $table->unsignedBigInteger('sensor_data_id');
        //         $table->unsignedBigInteger('vessel_id');
        //         $table->decimal('latitude', 10, 7);
        //         $table->decimal('longitude', 10, 7);
        //         $table->decimal('speed', 8, 2);
        //         $table->unsignedSmallInteger('course')->nullable();
        //         $table->unsignedSmallInteger('heading')->nullable();
        //         $table->string('navigation_status')->nullable();
        //         $table->integer('turning_rate')->nullable();
        //         $table->integer('turning_direction')->nullable();
        //         $table->timestamp('timestamp');
        //         $table->decimal('distance', 8, 2)->nullable();
        //         $table->tinyInteger('is_inside_geofence')->default(0);
        //         $table->tinyInteger('is_geofence')->default(0);
    
        //         $table->timestamps();
    
        //         $table->index('sensor_data_id');
        //         $table->index('vessel_id');
        //         $table->index('timestamp');
        //         $table->index('created_at');
        //     });
            
        //     // MySQL partitioning
        //     $currentYear = date('Y');
        //     $partitions = [];
        //     for ($year = $currentYear; $year <= $currentYear + 5; $year++) {
        //         $partitions[] = new Partition('year' . $year, Partition::RANGE_TYPE, strtotime(($year + 1) . '-01-01'));
        //     }

        //     Schema::partitionByRange('partitioned_ais_data_positions', 'UNIX_TIMESTAMP(timestamp)', $partitions, true);
        // }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('partitioned_ais_data_positions');
    }
};
