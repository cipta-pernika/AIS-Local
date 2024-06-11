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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ais_data_vessel_id');
            $table->string('sertifikat');
            $table->date('tgl_terbit');
            $table->date('tgl_expired');
            $table->timestamps();

            $table->foreign('ais_data_vessel_id')->references('id')->on('ais_data_vessels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
