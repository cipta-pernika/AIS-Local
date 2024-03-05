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
        Schema::create('inaportnet_bongkar_muats', function (Blueprint $table) {
            $table->id();
            $table->integer('id_rkbm');
            $table->integer('ais_data_vessel_id')->nullable();
            $table->string('pbm_kode')->nullable();
            $table->string('no_pkk')->nullable();
            $table->string('no_surat_keluar')->nullable();
            $table->string('kade')->nullable();
            $table->date('rencana_bongkar')->nullable();
            $table->date('rencana_muat')->nullable();
            $table->date('mulai_bongkar')->nullable();
            $table->date('mulai_muat')->nullable();
            $table->timestamp('actual_mulai_bongkar')->nullable();
            $table->timestamp('actual_mulai_muat')->nullable();
            $table->date('selesai_bongkar')->nullable();
            $table->date('selesai_muat')->nullable();
            $table->timestamp('actual_selesai_bongkar')->nullable();
            $table->timestamp('actual_selesai_muat')->nullable();
            $table->string('nomor_layanan_masuk')->nullable();
            $table->string('nomor_layanan_sps')->nullable();
            $table->string('nama_kapal')->nullable();
            $table->integer('gt_kapal')->nullable();
            $table->integer('panjang_kapal')->nullable();
            $table->integer('dwt')->nullable();
            $table->string('siupal_pemilik')->nullable();
            $table->string('siupal_operator')->nullable();
            $table->string('bendera')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->string('nomor_produk')->nullable();
            $table->string('tipe_kapal')->nullable();
            $table->string('pbm')->nullable();
            $table->longText('bongkar')->nullable();
            $table->longText('muat')->nullable();
            $table->longText('image_mulai')->nullable();
            $table->longText('image_sedang')->nullable();
            $table->longText('image_selesai')->nullable();
            $table->longText('image_mulai_2')->nullable();
            $table->longText('image_sedang_2')->nullable();
            $table->longText('image_selesai_2')->nullable();
            $table->longText('image_mulai_3')->nullable();
            $table->longText('image_sedang_3')->nullable();
            $table->longText('image_selesai_3')->nullable();
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
        Schema::dropIfExists('inaportnet_bongkar_muats');
    }
};
