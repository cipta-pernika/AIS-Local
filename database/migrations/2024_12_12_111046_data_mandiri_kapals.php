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
        Schema::create('data_mandiri_kapals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ais_data_vessel_id')->nullable();
            $table->unsignedBigInteger('inaportnet_bongkar_muat_id')->nullable();
            $table->unsignedBigInteger('inaportnet_pergerakan_kapal_id')->nullable();
            $table->unsignedBigInteger('impt_pelayanan_kapal_id')->nullable();
            $table->unsignedBigInteger('impt_penggunaan_alat_id')->nullable();
            $table->unsignedBigInteger('pbkm_kegiatan_pemanduan_id')->nullable();
            $table->tinyInteger('isPassing')->default(0);
            $table->tinyInteger('isPandu')->default(0);
            $table->tinyInteger('isBongkarMuat')->default(0);
            $table->unsignedBigInteger('geofence_id')->nullable();
            $table->unsignedBigInteger('ais_data_position_id')->nullable();
            $table->unsignedBigInteger('report_geofence_id')->nullable();
            $table->unsignedBigInteger('report_geofence_bongkar_muat_id')->nullable();
            $table->unsignedBigInteger('report_geofence_pandu_id')->nullable();

            $table->json('pandu_valid')->nullable();
            $table->json('pandu_tidak_terjadwal')->nullable();
            $table->json('pandu_late')->nullable();
            $table->json('bongkar_muat_valid')->nullable();
            $table->json('bongkar_muat_tidak_terjadwal')->nullable();
            $table->json('bongkar_muat_late')->nullable();

            $table->decimal('pnbp_jasa_labuh_kapal', 15, 2);
            $table->decimal('pnbp_jasa_rambu_kapal', 15, 2);
            $table->decimal('pnbp_jasa_vts_kapal_domestik', 15, 2);
            $table->decimal('pnbp_jasa_vts_kapal_asing', 15, 2);
            $table->decimal('pnbp_jasa_tambat_kapal', 15, 2);
            $table->decimal('pnbp_jasa_pemanduan_penundaan_marabahan', 15, 2);
            $table->decimal('pnbp_jasa_pemanduan_penundaan_trisakti', 15, 2);
            $table->decimal('pnbp_jasa_barang', 15, 2);
            $table->decimal('pnbp_jasa_pengawasan_bongkar_muat_1_percent', 15, 2);
            $table->decimal('pnbp_bongkar_muat_barang_berbahaya', 15, 2);


            $table->json('konsesi')->nullable();
            $table->json('tarif_terkonsolidasi')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('ais_data_position_id')->references('id')->on('ais_data_positions')->onDelete('cascade');
            $table->foreign('ais_data_vessel_id')->references('id')->on('ais_data_vessels')->onDelete('cascade');
            $table->foreign('geofence_id')->references('id')->on('geofences')->onDelete('cascade');
            $table->foreign('inaportnet_bongkar_muat_id', 'fk_inaportnet_bongkar_muat_id')
                ->references('id')->on('inaportnet_bongkar_muats')
                ->onDelete('cascade');
            $table->foreign('impt_pelayanan_kapal_id')->references('id')->on('impt_pelayanan_kapals')->onDelete('cascade');
            $table->foreign('impt_penggunaan_alat_id')->references('id')->on('impt_penggunaan_alats')->onDelete('cascade');
            $table->foreign('pbkm_kegiatan_pemanduan_id', 'fk_pbkm_kegiatan_pemanduan_id')
                ->references('id')->on('pbkm_kegiatan_pemanduans')
                ->onDelete('cascade');
            $table->foreign('report_geofence_id')->references('id')->on('report_geofences')->onDelete('cascade');
            $table->foreign('report_geofence_bongkar_muat_id')->references('id')->on('report_geofence_bongkar_muats')->onDelete('cascade');


            // Indexes
            $table->unique(['ais_data_vessel_id', 'created_at']);
            $table->index('ais_data_vessel_id');
            $table->index('inaportnet_bongkar_muat_id');
            $table->index('inaportnet_pergerakan_kapal_id', 'idx_inaportnet_pergerakan_kapal_id');
            $table->index('impt_pelayanan_kapal_id');
            $table->index('impt_penggunaan_alat_id');
            $table->index('pbkm_kegiatan_pemanduan_id');
            $table->index('report_geofence_id');
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
