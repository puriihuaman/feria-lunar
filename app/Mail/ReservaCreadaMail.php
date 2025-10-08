<?php

namespace App\Mail;

use App\Models\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservaCreadaMail extends Mailable
{
    use Queueable, SerializesModels;
    public $sede;
    public $stand;

    /**
     * Create a new message instance.
     */
    public function __construct(public Reserva $reservation)
    {
        $this->sede = optional($reservation->sedeStand->sede);
        $this->stand = optional($reservation->sedeStand->stand);
    }

    public function build()
    {
        return $this->subject('Confirmación de Reserva - ' . config('app.name'))
                    ->markdown('emails.reserva-creada')
                    ->text('emails.reserva-creada-plain')
                    ->with([
                        'reserva' => $this->reservation,
                        'sede' => $this->sede,
                        'stand' => $this->stand
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reserva Agendada - Feria Lunar',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reserva-creada',
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
