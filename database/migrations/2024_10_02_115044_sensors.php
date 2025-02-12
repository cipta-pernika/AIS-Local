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
        if (!Schema::hasTable('sensors')) {
            Schema::create('sensors', function (Blueprint $table) {
                $table->id()->autoIncrement();
                $table->string('name');
                $table->string('status');
                $table->integer('interval');
                $table->integer('jarak');
                $table->integer('jumlah_data');
                // Kolom-kolom ini akan ditambahkan jika tabel belum ada
                $table->string('latitude');
                $table->string('longitude');
                $table->string('altitude');
                $table->string('kompas');
                $table->foreignId('datalogger_id')->constrained('dataloggers');

                $table->timestamps();
            });
        } else {
            Schema::table('sensors', function (Blueprint $table) {
                if (DB::getDriverName() == 'pgsql') {
                    if (!Schema::hasColumn('sensors', 'latitude')) {
                        $table->string('latitude')->nullable();
                    }
                    if (!Schema::hasColumn('sensors', 'longitude')) {
                        $table->string('longitude')->nullable();
                    }
                    if (!Schema::hasColumn('sensors', 'altitude')) {
                        $table->string('altitude')->nullable();
                    }
                    if (!Schema::hasColumn('sensors', 'kompas')) {
                        $table->string('kompas')->nullable();
                    }
                } else {
                    if (!Schema::hasColumn('sensors', 'latitude')) {
                        $table->string('latitude');
                    }
                    if (!Schema::hasColumn('sensors', 'longitude')) {
                        $table->string('longitude');
                    }
                    if (!Schema::hasColumn('sensors', 'altitude')) {
                        $table->string('altitude');
                    }
                    if (!Schema::hasColumn('sensors', 'kompas')) {
                        $table->string('kompas');
                    }
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensors');
    }
};
