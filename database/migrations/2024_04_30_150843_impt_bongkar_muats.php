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
        Schema::create('impt_bongkar_muats', function (Blueprint $table) {
            $table->id();
            $table->integer('id_impt_bongkar_muat');
            $table->string('no_pkk')->nullable();
            $table->string('rkbm')->nullable();
            $table->integer('ais_data_vessel_id')->nullable();
            $table->string('nomor_registrasi_cargo')->nullable();

            $table->string('nama_kapal')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->string('pemilik_barang')->nullable();
            $table->string('jenis')->nullable();
            $table->integer('jumlah_tonase')->nullable();
            $table->integer('jumlah_biaya')->nullable();
            $table->integer('jumlah_pnbp')->nullable();
            $table->string('kegiatan')->nullable();
            $table->timestamp('tanggal_mulai')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->timestamp('date')->nullable();

            
            $table->longText('image_mulai')->nullable();
            $table->longText('image_sedang')->nullable();
            $table->longText('image_selesai')->nullable();
            $table->longText('image_mulai_2')->nullable();
            $table->longText('image_sedang_2')->nullable();
            $table->longText('image_selesai_2')->nullable();
            $table->longText('image_mulai_3')->nullable();
            $table->longText('image_sedang_3')->nullable();
            $table->longText('image_selesai_3')->nullable();
            
            $table->string('no_pkk_assign')->nullable();
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
        Schema::dropIfExists('impt_bongkar_muats');
    }
};
