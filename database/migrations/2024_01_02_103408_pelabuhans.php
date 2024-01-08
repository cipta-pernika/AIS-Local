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
        Schema::create('pelabuhans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('un_locode')->unique()->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('radius')->nullable();
            $table->string('address')->nullable();
            $table->string('penanggung_jawab')->nullable();
            $table->string('no_izin_pengoperasian')->nullable();
            $table->string('tgl_izin_pengoperasian')->nullable();
            $table->string('penerbit_izin_pengoperasian')->nullable();
            $table->string('no_perjanjian_sewa_perairan')->nullable();
            $table->string('tgl_sewa_perairan')->nullable();
            $table->integer('luas_perairan')->nullable();
            $table->integer('jasa_pengunaan_perairan')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('masa_berlaku_izin_operasi')->nullable();
            $table->string('masa_berlaku_perjanjian_sewa_perairan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelabuhans');
    }
};
