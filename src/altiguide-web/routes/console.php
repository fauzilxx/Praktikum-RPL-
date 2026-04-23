<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\CancelExpiredTransactions;

// Jadwalkan pembersihan transaksi setiap 1 menit (Bebas diubah jadi ->everyFiveMinutes())
Schedule::command('altiguide:cancel-expired')->everyMinute();
