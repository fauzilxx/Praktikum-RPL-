<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Transaction;

class ETicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    protected $pdfContent;

    /**
     * Data Transaksi & Output PDF String
     */
    public function __construct(Transaction $transaction, $pdfContent)
    {
        $this->transaction = $transaction;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Judul Email / Subject
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-Ticket Pendakian AltiGuide - ' . $this->transaction->order_id,
        );
    }

    /**
     * Tampilan Body Emailnya (Versi HTML text)
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.eticket',
        );
    }

    /**
     * Lampirkan PDF-nya di sini
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, 'E-Ticket-' . $this->transaction->order_id . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
