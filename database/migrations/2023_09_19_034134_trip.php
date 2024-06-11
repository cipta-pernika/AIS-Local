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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->integer('asset_id');
            $table->string('trip_dispatcher')->nullable();
            $table->string('trip_name');
            $table->string('trip_leader');
            $table->string('trip_note');
            $table->tinyInteger('trip_status')->default(1);
            $table->timestamps();

            $table->index('asset_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
