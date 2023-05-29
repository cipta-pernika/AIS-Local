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
        Schema::create('sensors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('datalogger_id');
            $table->foreign('datalogger_id')->references('id')->on('dataloggers');
            $table->string('name');
            $table->string('status');
            $table->integer('interval')->comment('minute');
            $table->integer('jarak')->comment('nm; 0 untuk unlimited');
            $table->integer('jumlah_data')->comment('0 untuk unlimited');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensors');
    }
};
