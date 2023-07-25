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
        Schema::create('radar_datas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('target_id');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->float('altitude')->nullable();
            $table->float('speed')->nullable();
            $table->float('heading')->nullable();
            $table->float('course')->nullable();
            $table->float('range')->nullable();
            $table->float('bearing')->nullable();
            $table->float('distance_from_fak')->nullable();
            $table->timestamp('timestamp');
            $table->timestamps();

            $table->index('target_id');
            $table->index('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radar_datas');
    }
};