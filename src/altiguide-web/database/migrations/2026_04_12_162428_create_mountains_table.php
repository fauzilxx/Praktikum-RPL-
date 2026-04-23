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
        Schema::create('mountains', function (Blueprint $table) {
            $table->id('id')->primary();
            $table->string('name', 100);
            $table->string('slug')->unique();
            $table->string('location', 100); // Kabupaten/Provinsi
            $table->integer('altitude'); // MDPL
            $table->text('description')->nullable(); 
            $table->decimal('latitude', 10, 8); // Presisi tinggi untuk peta
            $table->decimal('longitude', 11, 8);
            $table->string('image')->nullable();
            $table->enum('status', ['open', 'closed', 'alert'])->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mountains');
    }
};
