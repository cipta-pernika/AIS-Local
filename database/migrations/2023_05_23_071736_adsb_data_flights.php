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
        Schema::create('adsb_data_flights', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aircraft_id');
            $table->string('flight_number');
            $table->date('date');
            $table->string('from');
            $table->string('to');
            $table->decimal('flight_time', 8, 2);
            $table->timestamp('std')->nullable();
            $table->timestamp('atd')->nullable();
            $table->timestamp('sta')->nullable();

            // Foreign key constraint
            $table->foreign('aircraft_id')->references('id')->on('adsb_data_aircrafts')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adsb_data_flights');
    }
};
