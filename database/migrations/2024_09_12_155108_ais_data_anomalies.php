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
        Schema::create('ais_data_anomalies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ais_data_position_id')->constrained('ais_data_positions');
            $table->string('anomaly_type');
            $table->string('anomaly_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ais_data_anomalies');
    }
};
