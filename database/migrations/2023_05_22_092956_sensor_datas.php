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

        if (config('database.default') === 'pgsql') {
            // PostgreSQL implementation for partitioned table
            DB::statement("
                CREATE TABLE sensor_datas (
                    id BIGSERIAL PRIMARY KEY,
                    sensor_id BIGINT NOT NULL,
                    payload TEXT NOT NULL,
                    timestamp TIMESTAMP NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    CONSTRAINT fk_sensor FOREIGN KEY (sensor_id) REFERENCES sensors(id)
                ) PARTITION BY RANGE (timestamp);
            ");

            // Create the first partition for the current month
            $this->createPartition(date('Y'), date('m'));
        }

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

    private function createPartition($year, $month)
    {
        $partitionName = "sensor_datas_{$year}_{$month}";
        $startDate = "{$year}-{$month}-01 00:00:00";
        $endDate = date('Y-m-d H:i:s', strtotime("+1 month", strtotime($startDate)));

        DB::statement("
            CREATE TABLE $partitionName PARTITION OF sensor_datas
            FOR VALUES FROM ('$startDate') TO ('$endDate');
        ");
    }
};
