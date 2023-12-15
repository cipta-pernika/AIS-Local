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
        Schema::create('report_geofences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('ais_data_position_id')->nullable();
            $table->unsignedBigInteger('geofence_id')->nullable();
            $table->timestamp('in');
            $table->timestamp('out');
            $table->string('total_time')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('ais_data_position_id')->references('id')->on('ais_data_positions')->onDelete('cascade');
            $table->foreign('geofence_id')->references('id')->on('geofences')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_geofences');
    }
};
