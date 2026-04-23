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
        Schema::create('hiking_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('leader_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('route_id')->constrained('routes')->onDelete('cascade');
            $table->foreignUuid('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->string('group_name', 100);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('hike_type', ['tektok', 'camp'])->default('camp');
            $table->enum('status', ['prepared', 'on_track', 'finished'])->default('prepared');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hiking_sessions');
    }
};
