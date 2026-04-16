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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // order_id: Varchar(50) - ID unik untuk Midtrans
            $table->string('order_id', 50)->unique();

            // gross_amount: Decimal(12,2) - Total harga
            $table->decimal('gross_amount', 12, 2);

            // qr_url: Text - URL gambar QR
            $table->text('qr_url')->nullable();

            // payment_type: Varchar(20) - Default: 'qris'
            $table->string('payment_type', 20)->default('qris');

            // status: Enum (pending, settlement, expire, deny)
            $table->enum('status', ['pending', 'settlement', 'expire', 'deny'])->default('pending');

            // transaction_id: Varchar(100) - ID resmi dari Midtrans
            $table->string('transaction_id', 100)->nullable();

            // expiry_time: Timestamp - Batas waktu bayar
            $table->timestamp('expiry_time')->nullable();

            // created_at & updated_at: Timestamp - Waktu pesanan dibuat
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
