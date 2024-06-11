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
        Schema::create('pnbp_jasa_pengawasan_bongkar_muat', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_komoditi');
            $table->decimal('tarif', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pnbp_jasa_pengawasan_bongkar_muat');
    }
};
