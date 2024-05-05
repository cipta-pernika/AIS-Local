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
        Schema::create('pandu_tidak_terjadwals', function (Blueprint $table) {
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
            $table->string('nomor_spk_pandu')->nullable();
            $table->unsignedBigInteger('ais_data_position_id')->nullable();
            $table->unsignedBigInteger('report_geofence_id')->nullable();
            $table->unsignedBigInteger('report_geofence_bongkar_muat_id')->nullable();
            $table->unsignedBigInteger('report_geofence_pandu_id')->nullable();
            $table->string('vessel_name')->nullable();
            $table->string('mmsi')->nullable();

            
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

            $table->decimal('tonase_bongkar', 15, 2);
            $table->decimal('tonase_muat', 15, 2);

            
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('ais_data_position_id')->references('id')->on('ais_data_positions')->onDelete('cascade');
            $table->foreign('ais_data_vessel_id')->references('id')->on('ais_data_vessels')->onDelete('cascade');
            $table->foreign('geofence_id')->references('id')->on('geofences')->onDelete('cascade');
            $table->foreign('report_geofence_id')->references('id')->on('report_geofences')->onDelete('cascade');


            // Indexes
            $table->unique(['ais_data_vessel_id', 'created_at']);
            $table->index('ais_data_vessel_id');
            $table->index('report_geofence_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pandu_tidak_terjadwals');
    }
};
