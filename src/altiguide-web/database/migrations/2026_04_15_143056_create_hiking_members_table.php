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
        Schema::create('hiking_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('hiking_session_id')->constrained('hiking_sessions')->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('identity_number', 50);
            $table->string('full_name', 100);
            $table->string('phone_number', 30);
            $table->string('emergency_contact', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hiking_members');
    }
};
