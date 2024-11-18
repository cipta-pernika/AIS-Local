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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('initial_name')->nullable();
            $table->unsignedBigInteger('location_type_id');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->timestamps();
        
            $table->index('name');

            $table->foreign('location_type_id')->references('id')->on('location_types')->onDelete('restrict')->onUpdate('cascade');
        });
        
        Schema::table('locations', function (Blueprint $table) {
            $table->index('location_type_id');
        });
        
        Schema::table('locations', function (Blueprint $table) {
            $table->index(['latitude', 'longitude']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
