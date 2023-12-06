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
        Schema::create('geofence_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('base_price', 10, 2)->nullable();
            $table->string('uom')->nullable();
            $table->string('vessel_type')->nullable();
            $table->integer('speed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geofence_types');
    }
};
