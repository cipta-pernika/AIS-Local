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
        Schema::create('muatan_tarifs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['luar_negeri', 'dalam_negeri']);
            $table->decimal('curah_kering_food_grain', 8, 2);
            $table->decimal('curah_kering_non_food_grain', 8, 2);
            $table->decimal('general_cargo', 8, 2);
            $table->decimal('petikemas_20', 8, 2);
            $table->decimal('petikemas_40', 8, 2);
            $table->decimal('curah_cair', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muatan_tarifs');
    }
};
