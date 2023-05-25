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
            $table->string('aircraft_name');
            $table->string('aircraft_type');
            $table->string('acid')->unique();
            $table->string('registration')->nullable();
            $table->string('country');
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
