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
        Schema::create('adsb_data_aircrafts', function (Blueprint $table) {
            $table->id();
            $table->string('aircraft_name')->nullable();
            $table->string('aircraft_type')->nullable();
            $table->string('acid')->unique()->nullable();
            $table->string('registration')->nullable();
            $table->string('country')->nullable();
            $table->string('callsign')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adsb_data_aircrafts');
    }
};
