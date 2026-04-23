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
        Schema::create('route_waypoints', function (Blueprint $table) {
            $table->id('id')->primary();
            $table->foreignId('route_id')->constrained('routes')->onDelete('cascade');
            $table->string('name', 150);
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->integer('altitude')->nullable();
            $table->integer('order_index')->default(0);
            $table->decimal('distance_from_prev', 6, 2)->nullable(); // Jarak dalam km
            $table->integer('estimated_time_minutes')->nullable(); 
            $table->text('description')->nullable();
            $table->boolean('has_water_source')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_waypoints');
    }
};
