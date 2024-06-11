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
        Schema::create('ais_data_vessels', function (Blueprint $table) {
            $table->id();
            $table->string('vessel_name')->nullable();
            $table->string('vessel_type')->nullable();
            $table->string('mmsi')->unique();
            $table->integer('imo')->nullable()->comment('ship id');
            $table->string('callsign')->nullable();
            $table->integer('draught')->nullable()->comment('Draught Reported (m)');
            $table->string('dimension_to_bow')->nullable();
            $table->string('dimension_to_stern')->nullable();
            $table->string('dimension_to_port')->nullable();
            $table->string('dimension_to_starboard')->nullable();
            $table->string('reported_destination')->nullable();
            $table->tinyInteger('out_of_range')->default(0);
            $table->integer('type_number')->nullable();
            $table->timestamp('reported_eta')->nullable();

            //data inaportnet
            $table->string('no_pkk')->nullable();
            $table->string('jenis_layanan')->nullable();
            $table->string('nama_negara')->nullable();
            $table->string('tipe_kapal')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->string('tgl_tiba')->nullable();
            $table->string('tgl_brangkat')->nullable();
            $table->string('bendera')->nullable();
            $table->integer('gt_kapal')->nullable();
            $table->string('dwt')->nullable();
            $table->string('nakhoda')->nullable();
            $table->string('jenis_trayek')->nullable();
            $table->string('pelabuhan_asal')->nullable();
            $table->string('pelabuhan_tujuan')->nullable();
            $table->string('lokasi_lambat_labuh')->nullable();
            $table->string('nomor_spog')->nullable();
            
            $table->string('jenis_muatan')->nullable();
            $table->string('no_pandu')->nullable();
            $table->string('nama_pandu')->nullable();

            //siska
            $table->string('nama_kapal_eks')->nullable();
            $table->string('nama_kapal_pemilik')->nullable();
            $table->string('loa')->nullable();

            $table->integer('counting_hari')->nullable();
            $table->date('tgl_counting_hari')->nullable();
            $table->date('last_update_counting')->nullable();

            $table->tinyInteger('isAssign')->default(0);

            $table->string('nama_kapal_inaportnet')->nullable();

            $table->timestamps();

            $table->index('id');
            $table->index('mmsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ais_data_vessels');
    }
};
