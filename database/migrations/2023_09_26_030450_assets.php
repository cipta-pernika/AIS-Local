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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_name')->nullable();
            $table->string('asset_author')->nullable();
            $table->string('asset_type')->nullable();
            $table->string('asset_owner')->nullable();
            $table->string('mmsi')->nullable();
            $table->string('callsign')->nullable();
            $table->string('imo')->nullable();
            $table->string('image')->nullable();
            $table->integer('kapasitas_muatan')->nullable();
            $table->string('panjang')->nullable();
            $table->string('lebar')->nullable();
            $table->string('lebar_lambung')->nullable();
            $table->string('tinggi_geladak')->nullable();
            $table->string('mesin_pengerak')->nullable();
            $table->string('max_speed')->nullable();
            $table->string('kapasitas_awak_kapal')->nullable();
            $table->string('kapasitas_pasukan')->nullable();
            $table->string('kapasitas_tangki_bbm')->nullable();
            $table->string('kapasitas_air_tawar')->nullable();
            $table->string('kapasitas_jarak_jelajah')->nullable();
            $table->string('kapasitas_dead_weight')->nullable();
            $table->string('muatan_tank')->nullable();
            $table->string('muatan_transporter')->nullable();
            $table->string('muatan_helikopter')->nullable();
            $table->string('muatan_sepeda_motor')->nullable();
            $table->string('muatan_buldozer')->nullable();
            $table->string('konstruksi')->nullable();
            $table->string('profil')->nullable();
            $table->string('sarat_kapal')->nullable();
            $table->string('berat_benam')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['asset_name', 'asset_type']);
            $table->index('mmsi');
            $table->index('imo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
