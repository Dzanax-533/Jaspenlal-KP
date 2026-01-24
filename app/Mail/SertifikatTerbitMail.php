<?php

namespace App\Mail;

use App\Models\Pendaftaran;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class SertifikatTerbitMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftaran;

    public function __construct(Pendaftaran $pendaftaran)
    {
        $this->pendaftaran = $pendaftaran;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat! Sertifikat Halal Anda Telah Terbit - ' . $this->pendaftaran->no_pendaftaran,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.sertifikat-terbit',
        );
    }
}
