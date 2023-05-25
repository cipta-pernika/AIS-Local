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
            $table->unsignedBigInteger('port_id')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->decimal('speed', 8, 2);
            $table->integer('course')->nullable();
            $table->integer('heading')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('timestamp');

            // Foreign key constraints
            $table->foreign('sensor_data_id')->references('id')->on('sensor_datas')->onDelete('cascade');
            $table->foreign('vessel_id')->references('id')->on('ais_data_vessels')->onDelete('cascade');
            $table->foreign('port_id')->references('id')->on('ais_data_ports')->onDelete('cascade');

            $table->timestamps();
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
