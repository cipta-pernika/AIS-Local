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
        Schema::create('trackings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id')->nullable(); // Use an appropriate data type
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable(); // Adjusted the precision to match latitude
            $table->decimal('altitude', 8, 2)->nullable(); // Adjusted the precision
            $table->decimal('velocity', 8, 2)->nullable(); // Adjusted the precision
            $table->decimal('heading', 8, 2)->nullable(); // Adjusted the precision
            $table->unsignedBigInteger('event_id')->nullable(); // Use an appropriate data type
            $table->decimal('bat_lvl', 8, 2)->nullable(); // Adjusted the precision
            $table->string('signal')->nullable();
            $table->timestamp('timestamp')->nullable(); // Use a timestamp data type
            $table->string('data_flow_id')->nullable();
            $table->unsignedBigInteger('engine_rpm_id')->nullable(); // Use an appropriate data type
            $table->decimal('bat_hours', 8, 2)->nullable(); // Adjusted the precision
            $table->string('satellite')->nullable();
            $table->string('location')->nullable();
            $table->string('orbcomm_id')->nullable();
            $table->timestamps();

            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');

            $table->index('asset_id'); // Index for asset_id if it's frequently queried
            $table->index('timestamp'); // Index for timestamp if it's frequently queried
            // Add additional indexes based on your specific query patterns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trackings');
    }
};
