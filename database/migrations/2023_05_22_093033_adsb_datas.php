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
        Schema::create('adsb_datas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sensor_data_id');
            $table->foreign('sensor_data_id')->references('id')->on('sensor_datas');
            $table->string('aircraft_id');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->float('altitude');
            $table->float('ground_speed');
            $table->float('vertical_rate');
            $table->float('track');
            $table->timestamp('timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adsb_datas');
    }
};
