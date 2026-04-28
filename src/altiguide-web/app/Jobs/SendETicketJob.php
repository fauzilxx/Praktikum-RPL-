<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\ETicketMail;
use Illuminate\Support\Facades\Log;

class SendETicketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $transaction;

    /**
     * Create a new job instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Load relasi datarnya supaya tidak error saat ditarik di tampilan (View)
            $this->transaction->load([
                'user',
                'hikingSession.route.mountain',
                'hikingSession.members'
            ]);

            // 1. Generate PDF dari file Blade (resources/views/pdf/eticket.blade.php)
            $pdf = Pdf::loadView('pdf.eticket', ['transaction' => $this->transaction]);
            $pdfContent = $pdf->output();

            // 2. Kirim Email ke User bersangkutan beserta lampiran PDF-nya
            Mail::to($this->transaction->user->email)->send(new ETicketMail($this->transaction, $pdfContent));

            Log::info("E-Ticket berhasil dikirim ke email: " . $this->transaction->user->email . " untuk pesanan: " . $this->transaction->order_id);
            
        } catch (\Exception $e) {
            // Log jika terjadi masalah (misal server SMTP sedang down)
            Log::error("Gagal mengirim E-Ticket untuk pesanan: {$this->transaction->order_id}. Error: " . $e->getMessage());
        }
    }
}
