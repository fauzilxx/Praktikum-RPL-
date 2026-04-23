<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CancelExpiredTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'altiguide:cancel-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otomatis menandai transaksi yang kadaluwarsa (1 jam) menjadi expired.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Cari transaksi yang statusnya masih 'pending' dan expiry_time sudah lewat (di masa lalu dari waktu sekarang)
        $expiredTransactions = Transaction::where('status', 'pending')
            ->where('expiry_time', '<=', Carbon::now())
            ->get();

        $count = $expiredTransactions->count();

        if ($count > 0) {
            foreach ($expiredTransactions as $transaction) {
                // Ubah status menjadi 'expire'
                $transaction->status = 'expire';
                $transaction->save();
                
                // Opsional kalau ada log khusus di HikingSession, tapi di sisi Booking (TransactionController)
                // Kita sudah otomatis melepas kuota jika status transaksi bukan 'pending' atau 'settlement'
            }

            $this->info("Berhasil menggugurkan {$count} transaksi yang kadaluwarsa.");
            Log::info("[CRON] Sistem membatalkan {$count} transaksi yang telah lewat batas waktu 1 jam.");
        } else {
            $this->info("Tidak ada transaksi kadaluwarsa saat ini.");
        }
    }
}
