<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('adsb_data_positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('sensor_data_id');
            $table->unsignedInteger('aircraft_id');
            $table->unsignedInteger('flight_id');
            $table->float('latitude', 10, 6);
            $table->float('longitude', 10, 6);
            $table->unsignedMediumInteger('altitude');
            $table->unsignedSmallInteger('ground_speed')->default(0);
            $table->unsignedSmallInteger('heading')->default(0);
            $table->smallInteger('vertical_rate')->nullable();
            $table->smallInteger('track')->nullable();
            $table->dateTime('timestamp');
            $table->unsignedTinyInteger('transmission_type');

            // Foreign key constraints
            $table->foreign('sensor_data_id')->references('id')->on('sensor_datas')->onDelete('cascade');
            $table->foreign('aircraft_id')->references('id')->on('adsb_data_aircrafts')->onDelete('cascade');

            $table->timestamps();
        });

        // Add performance indexes
        DB::statement('CREATE INDEX idx_timestamp ON adsb_data_positions (timestamp)');
        DB::statement('CREATE INDEX idx_aircraft ON adsb_data_positions (aircraft_id)');
        DB::statement('CREATE INDEX idx_flight ON adsb_data_positions (flight_id)');
        DB::statement('CREATE INDEX idx_geo ON adsb_data_positions (latitude, longitude)');
        
        // For MySQL partitioning (uncomment if using MySQL)
        // DB::statement('
        //     ALTER TABLE adsb_data_positions 
        //     PARTITION BY RANGE(YEAR(timestamp)) (
        //         PARTITION p2023 VALUES LESS THAN (2024),
        //         PARTITION p2024 VALUES LESS THAN (2025),
        //         PARTITION p2025 VALUES LESS THAN (2026),
        //         PARTITION p2026 VALUES LESS THAN (2027)
        //     )
        // ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adsb_data_positions');
    }
};