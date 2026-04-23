<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordCode extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Kode OTP 6 digit yang akan dikirim ke email user.
     */
    public string $code;
    public string $userName;

    public function __construct(string $code, string $userName)
    {
        $this->code = $code;
        $this->userName = $userName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'AltiGuide — Kode Reset Password',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reset-password-code',
        );
    }
}
