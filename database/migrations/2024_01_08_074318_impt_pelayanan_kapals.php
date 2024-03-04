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
        Schema::create('impt_pelayanan_kapals', function (Blueprint $table) {
            $table->id();
            $table->string('no_pkk');
            $table->integer('ais_data_vessel_id')->nullable();
            $table->string('nama_kapal')->nullable();
            $table->string('gt')->nullable();
            $table->string('nama_agen_pelayaran')->nullable();
            $table->timestamp('waktu_kedatangan')->nullable();
            $table->timestamp('waktu_keberangkatan')->nullable();
            $table->string('posisi')->nullable();
            $table->integer('jumlah_biaya')->nullable();
            $table->integer('jumlah_pnbp')->nullable();
            $table->timestamp('date')->nullable();
            $table->longText('image_mulai')->nullable();
            $table->longText('image_sedang')->nullable();
            $table->longText('image_selesai')->nullable();
            $table->timestamps();

            $table->index('id');
            $table->index('no_pkk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impt_pelayanan_kapals');
    }
};
