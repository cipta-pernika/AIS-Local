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
        Schema::create('pnbp_jasa_labuh_kapals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ais_data_vessel_id')->nullable();
            $table->foreign('ais_data_vessel_id')->references('id')->on('ais_data_vessels')->onDelete('cascade');
            $table->integer('gt');
            $table->integer('kunjungan');
            $table->decimal('tarif_domestik', 10, 2);
            $table->decimal('tarif_asing', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pnbp_jasa_labuh_kapals');
    }
};
