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
        Schema::create('pandu_tidak_terjadwals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ais_data_vessel_id')->nullable();
            $table->tinyInteger('isPassing')->default(0);
            $table->unsignedBigInteger('geofence_id')->nullable();
            $table->string('nomor_spk_pandu')->nullable();
            $table->unsignedBigInteger('ais_data_position_id')->nullable();
            $table->unsignedBigInteger('report_geofence_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('ais_data_position_id')->references('id')->on('ais_data_positions')->onDelete('cascade');
            $table->foreign('ais_data_vessel_id')->references('id')->on('ais_data_vessels')->onDelete('cascade');
            $table->foreign('geofence_id')->references('id')->on('geofences')->onDelete('cascade');
            $table->foreign('report_geofence_id')->references('id')->on('report_geofences')->onDelete('cascade');


            // Indexes
            $table->unique(['ais_data_vessel_id', 'created_at']);
            $table->index('ais_data_vessel_id');
            $table->index('report_geofence_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pandu_tidak_terjadwals');
    }
};
