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
        Schema::create('ais_data_vessels', function (Blueprint $table) {
            $table->id();
            $table->string('vessel_name')->nullable();
            $table->string('vessel_type')->nullable();
            $table->string('mmsi')->unique();
            $table->integer('imo')->nullable()->comment('ship id');
            $table->string('callsign')->nullable();
            $table->integer('draught')->nullable()->comment('Draught Reported (m)');
            $table->string('dimension_to_bow')->nullable();
            $table->string('dimension_to_stern')->nullable();
            $table->string('dimension_to_port')->nullable();
            $table->string('dimension_to_starboard')->nullable();
            $table->string('reported_destination')->nullable();
            $table->enum('out_of_range', ['0', '1'])->default('0');
            $table->timestamp('reported_eta')->nullable();
            $table->timestamps();

            $table->index('mmsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ais_data_vessels');
    }
};
