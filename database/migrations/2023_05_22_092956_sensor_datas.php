<?php

use Illuminate\Database\Migrations\Migration;
// use Tpetry\PostgresqlEnhanced\Schema\Blueprint;
// use Tpetry\PostgresqlEnhanced\Support\Facades\Schema;
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

        if (env('DB_CONNECTION') === 'pgsql') {
            // Create trigger function for automatic partition creation
            DB::statement("
CREATE OR REPLACE FUNCTION create_sensor_data_partition()
RETURNS TRIGGER AS $$
BEGIN
    EXECUTE format('CREATE TABLE IF NOT EXISTS sensor_datas_%s PARTITION OF sensor_datas FOR VALUES FROM (''%s'') TO (''%s'')',
        to_char(NEW.timestamp, 'YYYY_MM'),
        to_char(NEW.timestamp, 'YYYY-MM-DD HH24:MI:SS'),
        to_char(NEW.timestamp + interval '1 month', 'YYYY-MM-DD HH24:MI:SS'));
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;
");

            // Create trigger for the sensor_datas table
            DB::statement("
CREATE TRIGGER sensor_data_partition_trigger
BEFORE INSERT ON sensor_datas
FOR EACH ROW EXECUTE FUNCTION create_sensor_data_partition();
");
        }
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
        if (env('DB_CONNECTION') === 'pgsql') {
            DB::statement("
            CREATE TABLE $partitionName PARTITION OF sensor_datas
            FOR VALUES FROM ('$startDate') TO ('$endDate');
        ");
        }
    }
};
