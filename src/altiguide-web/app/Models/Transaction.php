<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasUuids; // Menggunakan trait bawaan Laravel untuk primary key tipe UUID

    protected $fillable = [
        'user_id',
        'order_id',
        'gross_amount',
        'qr_url',
        'payment_type',
        'status',
        'transaction_id',
        'expiry_time',
    ];

    // Secara otomatis mem-parsing tanggal dan angka tipe desimal
    protected $casts = [
        'gross_amount' => 'decimal:2',
        'expiry_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hikingSession()
    {
        return $this->hasOne(HikingSession::class);
    }
}
