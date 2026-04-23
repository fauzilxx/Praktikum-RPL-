<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel untuk menyimpan kode OTP reset password.
     * Kode berlaku 15 menit setelah dibuat.
     */
    public function up(): void
    {
        Schema::create('password_reset_codes', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('code', 6);          // Kode OTP 6 digit
            $table->boolean('is_verified')->default(false); // Sudah diverifikasi?
            $table->timestamp('expires_at');     // Waktu kedaluwarsa
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('password_reset_codes');
    }
};
