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
        Schema::create('mission_plans', function (Blueprint $table) {
            $table->id();
            $table->string('asset_id');
            $table->string('dispatcher')->nullable();
            $table->string('name');
            $table->string('leader');
            $table->string('note');
            $table->enum('status', ['0', '1'])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_plans');
    }
};
