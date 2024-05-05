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
        Schema::create('trip_datas', function (Blueprint $table) {
            $table->id();
            $table->integer('trip_id');
            $table->decimal('trip_data_latitude', 10, 7);
            $table->decimal('trip_data_longitude', 10, 7)->nullable();
            $table->string('trip_data_etd')->nullable();
            $table->string('trip_data_eta')->nullable();
            $table->string('trip_data_pathname')->nullable();
            $table->string('trip_data_description')->nullable();
            $table->string('trip_data_note')->nullable();
            $table->tinyInteger('trip_data_status')->default(0);
            $table->string('trip_data_atd')->nullable();
            $table->string('trip_data_ata')->nullable();
            $table->timestamps();

            $table->index('trip_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_datas');
    }
};
