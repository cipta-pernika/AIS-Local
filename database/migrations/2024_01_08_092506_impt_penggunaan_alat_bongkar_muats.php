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
        Schema::create('impt_penggunaan_alats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('impt_source_id');
            $table->integer('ais_data_vessel_id')->nullable();
            $table->string('no_pkk');
            $table->string('nama_kapal')->nullable();
            $table->string('nomor_te')->nullable();
            $table->string('spog')->nullable();
            $table->string('nama_floting_crane')->nullable();
            $table->string('gt')->nullable();
            $table->string('agen_perusahaan_te')->nullable();
            $table->timestamp('tanggal_mulai_kegiatan')->nullable();
            $table->timestamp('tanggal_selesai_kegiatan')->nullable();
            $table->string('lama_penggunaaan')->nullable();
            $table->integer('jumlah_biaya')->nullable();
            $table->integer('jumlah_pnbp')->nullable();
            $table->timestamp('date')->nullable();
            $table->longText('image_mulai')->nullable();
            $table->longText('image_sedang')->nullable();
            $table->longText('image_selesai')->nullable();
            $table->string('mmsi')->nullable();
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
        Schema::dropIfExists('impt_penggunaan_alats');
    }
};
