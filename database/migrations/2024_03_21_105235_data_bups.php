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
        Schema::create('data_bups', function (Blueprint $table) {
            $table->id();
            $table->integer('id_rkbm')->nullable();
            $table->integer('ais_data_vessel_id')->nullable();
            $table->string('pbm_kode')->nullable();
            $table->string('no_pkk')->nullable()->unique();
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
            $table->string('no_pkk_assign')->nullable();
            $table->string('mmsi')->nullable();
            $table->string('jenis_layanan')->nullable();
            $table->string('nama_negara')->nullable();
            $table->timestamp('tgl_tiba')->nullable();
            $table->timestamp('tgl_brangkat')->nullable();
            $table->string('no_imo')->nullable();
            $table->string('call_sign')->nullable();
            $table->string('nakhoda')->nullable();
            $table->string('jenis_trayek')->nullable();
            $table->string('pelabuhan_asal')->nullable();
            $table->string('pelabuhan_tujuan')->nullable();
            $table->string('lokasi_lambat_labuh')->nullable();
            $table->string('waktu_respon')->nullable();
            $table->string('nomor_spog')->nullable();
            $table->string('no_pandu')->nullable();
            $table->string('nama_pandu')->nullable();
            $table->integer('grt')->nullable();
            $table->integer('loa')->nullable();
            $table->date('tanggal_pandu_naik_kapal')->nullable();
            $table->date('tanggal_pandu_turun_kapal')->nullable();
            $table->time('jam_pandu_naik_kapal')->nullable();
            $table->time('jam_pandu_turun_kapal')->nullable();
            $table->integer('biaya_layanan')->nullable();
            $table->integer('jumlah_pnbp')->nullable();
            $table->string('foto_di_kapal')->nullable();
            $table->string('bpjp')->nullable();
            $table->timestamps();

            $table->index('id');
            if (DB::getDriverName() !== 'mongodb') {
                $table->index('no_pkk');
            }
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_mandiri_kapals');
    }
};
