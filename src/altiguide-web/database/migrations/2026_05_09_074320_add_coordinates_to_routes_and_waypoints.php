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
        Schema::table('route_waypoints', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('altitude');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });

        Schema::table('routes', function (Blueprint $table) {
            $table->json('track_coordinates')->nullable()->after('longitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('route_waypoints', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });

        Schema::table('routes', function (Blueprint $table) {
            $table->dropColumn('track_coordinates');
        });
    }
};
