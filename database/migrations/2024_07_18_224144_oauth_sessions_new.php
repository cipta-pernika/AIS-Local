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
        Schema::table('oauth_sessions', function (Blueprint $table) {
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->integer('expires_in')->nullable();
            $table->json('resource_owner')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oauth_sessions', function (Blueprint $table) {
            $table->dropColumn('access_token');
            $table->dropColumn('refresh_token');
            $table->dropColumn('expires_in');
            $table->dropColumn('resource_owner');
        });
    }
};
