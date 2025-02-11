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
        Schema::create('konsolidasis', function (Blueprint $table) {
            $table->id();
            $table->integer('passing')->default(0);
            $table->integer('pandu_tervalidasi')->default(0);
            $table->integer('pandu_tidak_terjadwal')->default(0);
            $table->integer('pandu_terlambat')->default(0);
            $table->integer('bongkar_muat_tervalidasi')->default(0);
            $table->integer('bongkar_muat_tidak_terjadwal')->default(0);
            $table->integer('bongkar_muat_terlambat')->default(0);
            $table->integer('total_kapal')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsolidasis');
    }
};
