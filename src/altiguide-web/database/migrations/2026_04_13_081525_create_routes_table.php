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
        Schema::create('routes', function (Blueprint $table) {
            $table->id('id')->primary();
            $table->foreignid('mountain_id')->constrained('mountains')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('slug')->unique();
            $table->decimal('distance', 8 , 2);
            $table->integer('estimated_time'); // in minutes
            $table->enum('difficulty', ['easy', 'moderate', 'hard']);  
            $table->string('image')->nullable();
            $table->integer('daily_quota')->default(70);
            $table->boolean('is_active')->default(true);
            $table->decimal('latitude', 10,8)->nullable();
            $table->decimal('longitude', 11,8)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
