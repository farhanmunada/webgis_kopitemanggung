<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Umkm;

class UMKMApproved extends Mailable
{
    use Queueable, SerializesModels;
    public $umkm;

    public function __construct(Umkm $umkm)
    {
        $this->umkm = $umkm;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran UMKM Anda Telah Disetujui',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.umkm-approved',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
