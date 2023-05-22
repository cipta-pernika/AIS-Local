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
        Schema::create('data_transfer_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sensor_data_id');
            $table->foreign('sensor_data_id')->references('id')->on('sensor_datas');
            $table->timestamp('timestamp');
            $table->integer('response_code');
            $table->integer('response_time');
            $table->text('additional_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_transfer_logs');
    }
};
