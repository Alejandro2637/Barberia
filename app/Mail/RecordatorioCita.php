<?php

namespace App\Mail;

use App\Models\Citas;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecordatorioCita extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Citas $cita,
        public string $enlaceCancelacion,
        public ?string $enlaceReprogramar = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recordatorio: tu cita es mañana',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.recordatorio-cita',
        );
    }
}
