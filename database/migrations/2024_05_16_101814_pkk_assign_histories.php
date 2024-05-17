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
        Schema::create('pkk_assign_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ais_data_vessel_id')->nullable();
            $table->string('no_pkk')->nullable();
            $table->string('no_pkk_assign')->nullable();
            $table->string('nama_perusahaan')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('ais_data_vessel_id')->references('id')->on('ais_data_vessels')->onDelete('cascade');


            // Indexes
            $table->index('ais_data_vessel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkk_assign_histories');
    }
};
