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
        Schema::create('route_infos', function (Blueprint $table) {
            $table->id('id')->primary();
            $table->foreignId('route_id')->constrained('routes')->onDelete('cascade');
            $table->text('basecamp_address')->nullable();
            $table->integer('basecamp_altitude')->nullable();
            $table->decimal('simaksi_price', 10, 2)->nullable();
            $table->text('facilities_description')->nullable();
            $table->text('logistics_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_infos');
    }
};
