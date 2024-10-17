<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Brokenice\LaravelMysqlPartition\Models\Partition;
use Brokenice\LaravelMysqlPartition\Schema\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('partitioned_ais_data_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sensor_data_id');
            $table->unsignedBigInteger('vessel_id');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->decimal('speed', 8, 2);
            $table->unsignedSmallInteger('course')->nullable();
            $table->unsignedSmallInteger('heading')->nullable();
            $table->string('navigation_status')->nullable();
            $table->integer('turning_rate')->nullable();
            $table->integer('turning_direction')->nullable();
            $table->timestamp('timestamp');
            $table->decimal('distance', 8, 2)->nullable(); 
            $table->tinyInteger('is_inside_geofence')->default(0);
            $table->tinyInteger('is_geofence')->default(0);
            
            $table->foreign('sensor_data_id')->references('id')->on('sensor_datas')->onDelete('cascade');
            $table->foreign('vessel_id')->references('id')->on('ais_data_vessels')->onDelete('cascade');

            $table->timestamps();

            $table->index('sensor_data_id');
            $table->index('vessel_id');
            $table->index('timestamp');
            $table->index('created_at');
        });

        // Add partitioning by years and months
        Schema::partitionByYearsAndMonths('partitioned_ais_data_positions', 'timestamp', 2024);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partitioned_ais_data_positions');
    }
};
