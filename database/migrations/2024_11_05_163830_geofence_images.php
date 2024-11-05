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
            $table->string('vessel_name')->nullable();
            $table->timestamp('timestamp');
            $table->timestamps();

            $table->foreign('geofence_id')
                  ->references('id')
                  ->on('geofences')
                  ->onDelete('cascade');
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
