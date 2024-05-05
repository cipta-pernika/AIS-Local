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
        Schema::create('pnbp_jasa_tambat_kapal', function (Blueprint $table) {
            $table->id();
            $table->decimal('gt', 10, 2); // Gross Tonnage
            $table->integer('etmal_hours'); // Etmal dalam jam
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
        Schema::dropIfExists('pnbp_jasa_tambat_kapal');
    }
};
