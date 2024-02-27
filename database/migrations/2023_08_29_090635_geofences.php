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
        Schema::create('geofences', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('geofence_type_id')->nullable();
            $table->integer('pelabuhan_id')->nullable();
            $table->integer('terminal_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->string('geofence_name')->nullable();
            $table->string('type')->nullable();
            $table->string('type_geo')->nullable();
            $table->string('radius')->nullable();
            $table->longText('geometry')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('pelabuhan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geofences');
    }
};
