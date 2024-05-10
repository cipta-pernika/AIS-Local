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
        Schema::create('pelindo_bongkar_muats', function (Blueprint $table) {
            $table->id();
            $table->string('no_pkk');
            $table->integer('ais_data_vessel_id')->nullable();
            $table->string('nama_kapal')->nullable();
            $table->string('nama_agent')->nullable();
            $table->string('ppk')->nullable();
            $table->integer('gt_kapal')->nullable();
            $table->integer('dwt')->nullable();
            $table->integer('loa')->nullable();
            $table->string('nama_dermaga')->nullable();
            $table->string('rea_mulai_bm')->nullable();
            $table->string('rea_selesai_bm')->nullable();
            $table->integer('jumlah_biaya')->nullable();
            $table->integer('jumlah_pnbp')->nullable();
            $table->string('id_rkbm')->nullable();
            $table->string('pbm')->nullable();
            $table->string('kegiatan_bongkar_muat')->nullable();
            $table->string('jenis_barang')->nullable();
            $table->integer('jumlah_barang')->nullable();
            $table->timestamp('rea_mulai_tambat')->nullable();
            $table->timestamp('rea_selesai_tambat')->nullable();
            $table->timestamp('created_at_pelindo')->nullable();

            $table->longText('image_mulai')->nullable();
            $table->longText('image_sedang')->nullable();
            $table->longText('image_selesai')->nullable();
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
        Schema::dropIfExists('pelindo_bongkar_muats');
    }
};
