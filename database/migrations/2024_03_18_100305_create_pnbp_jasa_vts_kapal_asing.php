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
        Schema::create('pnbp_jasa_vts_kapal_asing', function (Blueprint $table) {
            $table->id();
            $table->string('klasifikasi_besaran');
            $table->integer('gt_kapal_from')->nullable();
            $table->integer('gt_kapal_to')->nullable();
            $table->string('rumus');
            $table->string('variabel');
            $table->decimal('tarif_domestik', 10, 2)->nullable();
            $table->decimal('tarif_asing', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pnbp_jasa_vts_kapal_asing');
    }
};
