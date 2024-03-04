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
        Schema::create('inaportnet_pergerakan_kapals', function (Blueprint $table) {
            $table->id();
            $table->string('no_pkk');
            $table->integer('ais_data_vessel_id')->nullable();
            $table->string('nama_kapal')->nullable();
            $table->string('jenis_layanan')->nullable();
            $table->string('nama_negara')->nullable();
            $table->string('tipe_kapal')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->timestamp('tgl_tiba')->nullable();
            $table->timestamp('tgl_brangkat')->nullable();
            $table->string('bendera')->nullable();
            $table->integer('gt_kapal')->nullable();
            $table->integer('dwt')->nullable();
            $table->string('no_imo')->nullable();
            $table->string('call_sign')->nullable();
            $table->string('nakhoda')->nullable();
            $table->string('jenis_trayek')->nullable();
            $table->string('pelabuhan_asal')->nullable();
            $table->string('pelabuhan_tujuan')->nullable();
            $table->string('lokasi_lambat_labuh')->nullable();
            $table->string('waktu_respon')->nullable();
            $table->string('nomor_spog')->nullable();
            $table->longText('image_mulai')->nullable();
            $table->longText('image_sedang')->nullable();
            $table->longText('image_selesai')->nullable();
            $table->string('no_pkk_assign')->nullable();

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
        Schema::dropIfExists('inaportnet_pergerakan_kapals');
    }
};
