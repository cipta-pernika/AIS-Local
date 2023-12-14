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
        Schema::create('map_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('distance_unit')->nullable();
            $table->string('speed_unit')->nullable();
            $table->string('breadcrumb')->nullable();
            $table->integer('breadcrumb_point')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('coordinate_format')->nullable();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users');
        
            $table->index('user_id');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_settings');
    }
};
