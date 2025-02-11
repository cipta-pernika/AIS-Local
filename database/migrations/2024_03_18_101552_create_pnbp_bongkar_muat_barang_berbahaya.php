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
        Schema::create('pnbp_bongkar_muat_barang_berbahaya', function (Blueprint $table) {
            $table->id();
            $table->string('klasifikasi_barang');
            $table->decimal('tarif', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pnbp_bongkar_muat_barang_berbahaya');
    }
};
