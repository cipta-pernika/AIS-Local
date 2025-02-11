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
            $table->unsignedBigInteger('asset_id'); // Use an appropriate data type (assuming it references another table)
            $table->string('name')->unique();
            $table->timestamp('ETD')->nullable();
            $table->timestamp('ATD')->nullable();
            $table->timestamp('ETA')->nullable();
            $table->timestamp('ATA')->nullable();
            $table->text('route_plans')->nullable();
            $table->string('captain')->nullable();
            $table->string('muatan')->nullable();
            $table->text('note')->nullable(); // Changed to text data type for longer notes
            $table->tinyInteger('status')->default('1'); // Consider using integer or boolean for status
            $table->timestamps();

            $table->index('asset_id'); // Index for asset_id if it's frequently queried
            $table->index('name'); // Index for name if it's frequently queried
            // Add additional indexes based on your specific query patterns
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
