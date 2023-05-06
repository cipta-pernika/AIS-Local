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
        Schema::create('positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vessel_id');
            $table->foreign('vessel_id')->references('id')->on('vessels');
            $table->float('latitude');
            $table->float('longitude');
            $table->float('sog');
            $table->float('cog');
            $table->float('heading');
            $table->timestamp('timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
