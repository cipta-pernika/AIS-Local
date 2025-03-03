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
        if (config('database.default') === 'mysql') {
            // MySQL implementation with partitioning
            // Remove foreign keys from partitioned table as they're not supported with partitioning
            DB::statement("CREATE TABLE adsb_data_positions (
                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                sensor_data_id BIGINT UNSIGNED NOT NULL,
                aircraft_id BIGINT UNSIGNED NOT NULL,
                flight_id BIGINT UNSIGNED NOT NULL,
                latitude FLOAT(10,6) NOT NULL,
                longitude FLOAT(10,6) NOT NULL,
                altitude MEDIUMINT UNSIGNED NOT NULL,
                ground_speed SMALLINT UNSIGNED DEFAULT 0,
                heading SMALLINT UNSIGNED DEFAULT 0,
                vertical_rate SMALLINT DEFAULT NULL,
                track SMALLINT DEFAULT NULL,
                timestamp DATETIME NOT NULL,
                transmission_type TINYINT UNSIGNED NOT NULL,
                created_at TIMESTAMP NULL DEFAULT NULL,
                updated_at TIMESTAMP NULL DEFAULT NULL,
                PRIMARY KEY (id, timestamp),
                INDEX idx_timestamp (timestamp),
                INDEX idx_aircraft (aircraft_id),
                INDEX idx_flight (flight_id),
                INDEX idx_geo (latitude, longitude),
                INDEX idx_sensor_data (sensor_data_id)
            ) PARTITION BY RANGE (YEAR(timestamp)) (
                PARTITION p2023 VALUES LESS THAN (2024),
                PARTITION p2024 VALUES LESS THAN (2025),
                PARTITION p2025 VALUES LESS THAN (2026),
                PARTITION p2026 VALUES LESS THAN (2027),
                PARTITION pmax VALUES LESS THAN MAXVALUE
            )");
            
            // Create triggers to enforce referential integrity instead of foreign keys
            DB::unprepared("
                CREATE TRIGGER before_insert_adsb_data_positions
                BEFORE INSERT ON adsb_data_positions
                FOR EACH ROW
                BEGIN
                    DECLARE sensor_exists INT;
                    DECLARE aircraft_exists INT;
                    
                    SELECT COUNT(*) INTO sensor_exists FROM sensor_datas WHERE id = NEW.sensor_data_id;
                    SELECT COUNT(*) INTO aircraft_exists FROM adsb_data_aircrafts WHERE id = NEW.aircraft_id;
                    
                    IF sensor_exists = 0 THEN
                        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Foreign key constraint violation: sensor_data_id does not exist';
                    END IF;
                    
                    IF aircraft_exists = 0 THEN
                        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Foreign key constraint violation: aircraft_id does not exist';
                    END IF;
                END;
            ");
        } else {
            // Default implementation for other databases
            Schema::create('adsb_data_positions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('sensor_data_id');
                $table->unsignedInteger('aircraft_id');
                $table->unsignedInteger('flight_id');
                $table->float('latitude', 10, 6);
                $table->float('longitude', 10, 6);
                $table->unsignedMediumInteger('altitude');
                $table->unsignedSmallInteger('ground_speed')->default(0);
                $table->unsignedSmallInteger('heading')->default(0);
                $table->smallInteger('vertical_rate')->nullable();
                $table->smallInteger('track')->nullable();
                $table->dateTime('timestamp');
                $table->unsignedTinyInteger('transmission_type');

                $table->foreign('sensor_data_id')->references('id')->on('sensor_datas')->onDelete('cascade');
                $table->foreign('aircraft_id')->references('id')->on('adsb_data_aircrafts')->onDelete('cascade');

                $table->timestamps();
            });

            DB::statement('CREATE INDEX idx_timestamp ON adsb_data_positions (timestamp)');
            DB::statement('CREATE INDEX idx_aircraft ON adsb_data_positions (aircraft_id)');
            DB::statement('CREATE INDEX idx_flight ON adsb_data_positions (flight_id)');
            DB::statement('CREATE INDEX idx_geo ON adsb_data_positions (latitude, longitude)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (config('database.default') === 'mysql') {
            DB::unprepared("DROP TRIGGER IF EXISTS before_insert_adsb_data_positions");
        }
        Schema::dropIfExists('adsb_data_positions');
    }
};