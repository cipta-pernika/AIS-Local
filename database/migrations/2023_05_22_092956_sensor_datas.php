<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sensor_datas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sensor_id');
            $table->foreign('sensor_id')->references('id')->on('sensors');
            $table->text('payload');
            $table->timestamp('timestamp');
            $table->timestamps();

            $table->index('sensor_id');
        });

        $currentMonth = date('Y_m');
        Schema::create("sensor_datas_{$currentMonth}", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sensor_id');
            $table->foreign('sensor_id')->references('id')->on('sensors');
            $table->text('payload');
            $table->timestamp('timestamp');
            $table->timestamps();

            $table->index('sensor_id');
        });

        // Move data from sensor_datas to sensor_datas_{$currentMonth}
        DB::table('sensor_datas')->whereMonth('timestamp', date('m'))->get()->each(function ($data) use ($currentMonth) {
            DB::table("sensor_datas_{$currentMonth}")->insert((array) $data);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_datas');
    }
};
