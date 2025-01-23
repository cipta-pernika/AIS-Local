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
        Schema::create('geofence_images', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->string('mmsi');
            $table->unsignedBigInteger('geofence_id');
            $table->unsignedBigInteger('report_geofence_id')->nullable();
            $table->string('vessel_name')->nullable();
            $table->timestamp('timestamp');
            $table->timestamps();

            $table->foreign('geofence_id')
                  ->references('id')
                  ->on('geofences')
                  ->onDelete('cascade');
            $table->foreign('report_geofence_id')->references('id')->on('report_geofences')->onDelete('cascade');

            $table->index('report_geofence_id');
            $table->index('geofence_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geofence_images');
    }
};
