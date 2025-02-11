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
        Schema::create('bup_konsesis', function (Blueprint $table) {
            $table->id();
            $table->string('bup');
            $table->integer('bruto');
            $table->decimal('besaran_konsesi');
            $table->decimal('pendapatan_konsesi');
            $table->integer('month');
            
            $table->timestamps();
            $table->softDeletes();


            // Indexes
            $table->index('bup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bup_konsesis');
    }
};
