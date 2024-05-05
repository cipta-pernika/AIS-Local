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
        Schema::create('pnbp_jasa_rambu_kapal', function (Blueprint $table) {
            $table->id();
            $table->string('trayek');
            $table->string('jenis_kapal'); // Liner, Tramper, or Kapal Asing
            $table->decimal('gt', 10, 2)->nullable(); // Gross Tonnage
            $table->decimal('tarif_domestik', 10, 2)->nullable(); // Tarif Domestik
            $table->decimal('tarif_asing', 10, 2)->nullable(); // Tarif Asing
            $table->decimal('kurs', 10, 2)->nullable(); // Kurs $ saat diajukan PNBP
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pnbp_jasa_rambu_kapal');
    }
};
