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
        Schema::create('vessel_ports', function (Blueprint $table) {
            $table->unsignedBigInteger('vessel_id');
            $table->foreign('vessel_id')->references('id')->on('vessels');
            $table->unsignedBigInteger('port_id');
            $table->foreign('port_id')->references('id')->on('ports');
            $table->timestamp('visit_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vessel_ports');
    }
};
