<?php

namespace App\Mail;

use App\Models\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaidReservationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $reservation;
    public $sede;
    public $stand;

    /**
     * Create a new message instance.
     */
    public function __construct(Reserva $reservation)
    {
        $this->reservation = $reservation;
        $this->sede = optional($reservation->sedeStand->sede);
        $this->stand = optional($reservation->sedeStand->stand);
    }

    public function build() {
        return $this->subject('Confirmación de Pago - ' . config('app.name'))->markdown('emails.paid-reservation')->with(['reserva' => $this->reservation, 'sede' => $this->sede, 'stand' => $this->stand]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reserva Pagada - Feria Lunar',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.paid-reservation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
