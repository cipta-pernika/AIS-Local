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
        Schema::create('ais_data_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sensor_data_id');
            $table->unsignedBigInteger('vessel_id');
            // $table->unsignedBigInteger('port_id')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->decimal('speed', 8, 2);
            $table->unsignedSmallInteger('course')->nullable();
            $table->unsignedSmallInteger('heading')->nullable();
            $table->string('navigation_status')->nullable();
            $table->integer('turning_rate')->nullable();
            $table->unsignedTinyInteger('turning_direction')->nullable();
            $table->timestamp('timestamp');
            $table->decimal('distance', 8, 2)->nullable(); //distance from sensor
            $table->tinyInteger('is_inside_geofence')->default(0);
            $table->tinyInteger('is_geofence')->default(0);
            // Foreign key constraints
            $table->foreign('sensor_data_id')->references('id')->on('sensor_datas')->onDelete('cascade');
            $table->foreign('vessel_id')->references('id')->on('ais_data_vessels')->onDelete('cascade');
            // $table->foreign('port_id')->references('id')->on('ais_data_ports')->onDelete('cascade');

            $table->timestamps();

            $table->index('sensor_data_id');
            $table->index('vessel_id');
            $table->index('timestamp');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ais_data_positions');
    }
};
