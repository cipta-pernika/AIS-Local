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
        Schema::create('pnbp_pemanduan_kapal_trisakti', function (Blueprint $table) {
            $table->id();
            $table->string('jenis');
            $table->string('rumus');
            $table->string('variabel');
            $table->decimal('tarif_tetap', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pnbp_pemanduan_kapal_trisakti');
    }
};
