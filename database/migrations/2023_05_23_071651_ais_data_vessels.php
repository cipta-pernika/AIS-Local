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
            $table->string('vessel_name');
            $table->string('vessel_type');
            $table->string('mmsi')->unique();
            $table->string('flag');
            $table->string('imo')->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->timestamps();
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
