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
        Schema::create('pbkm_kegiatan_pemanduans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_spk_pandu');
            $table->string('no_pkk');
            $table->integer('ais_data_vessel_id')->nullable();
            $table->timestamp('tanggal_spk_pandu')->nullable();
            $table->string('nomor_imo')->nullable();
            $table->string('nomor_spog')->nullable();
            $table->string('npwp_agent')->nullable();
            $table->string('nama_agent')->nullable();
            $table->string('kode_dermaga_awal')->nullable();
            $table->string('nama_dermaga_awal')->nullable();
            $table->string('nama_dermaga_tujuan')->nullable();
            $table->string('no_pandu')->nullable();
            $table->string('nama_pandu')->nullable();
            $table->string('nama_kapal')->nullable();
            $table->string('bendera_kapal')->nullable();
            $table->integer('grt')->nullable();
            $table->integer('dwt')->nullable();
            $table->integer('loa')->nullable();
            $table->date('tanggal_pandu_naik_kapal')->nullable();
            $table->date('tanggal_pandu_turun_kapal')->nullable();
            $table->time('jam_pandu_naik_kapal')->nullable();
            $table->time('jam_pandu_turun_kapal')->nullable();
            $table->integer('biaya_layanan')->nullable();
            $table->integer('jumlah_pnbp')->nullable();
            $table->longText('image_mulai')->nullable();
            $table->longText('image_sedang')->nullable();
            $table->longText('image_selesai')->nullable();
            $table->timestamps();
            $table->timestamp('actual_mulai_bongkar')->nullable();
            $table->timestamp('actual_mulai_muat')->nullable();
            $table->timestamp('actual_selesai_bongkar')->nullable();
            $table->timestamp('actual_selesai_muat')->nullable();
            $table->string('mmsi')->nullable();
            $table->string('foto_di_kapal')->nullable();
            $table->string('bpjp')->nullable();
            $table->index('id');
            $table->index('no_pkk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pbkm_kegiatan_pemanduans');
    }
};
