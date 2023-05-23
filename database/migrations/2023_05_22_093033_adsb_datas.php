<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('adsb_data_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sensor_data_id');
            $table->unsignedBigInteger('aircraft_id');
            $table->string('flight_id');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->decimal('altitude', 8, 2);
            $table->decimal('ground_speed', 8, 2);
            $table->decimal('vertical_rate', 8, 2);
            $table->decimal('track', 8, 2);
            $table->timestamp('timestamp');

            // Foreign key constraints
            $table->foreign('sensor_data_id')->references('id')->on('sensor_data')->onDelete('cascade');
            $table->foreign('aircraft_id')->references('id')->on('adsb_data_aircrafts')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adsb_data_positions');
    }
};
