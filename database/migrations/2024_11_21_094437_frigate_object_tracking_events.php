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
        Schema::create('frigate_object_tracking_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_id');
            $table->string('camera');
            $table->string('event_type');
            $table->json('before_state')->nullable();
            $table->json('after_state')->nullable();
            $table->timestamps();

            $table->index('event_id');
            $table->index('camera');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frigate_object_tracking_events');
    }
};
