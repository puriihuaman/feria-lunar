<?php

namespace App\Jobs;

use App\Mail\CancelledReservationMail;
use App\Models\Reserva;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCancelledReservationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(public Reserva $reservation)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $reservation = $this->reservation->fresh(['sedeStand.sede', 'sedeStand.stand']);
            Mail::to($reservation->email)->send(new CancelledReservationMail($reservation));
            
            Log::info('Email de reserva cancelada enviado', [
                'reserva_id' => $reservation->id,
                'email' => $reservation->email,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error al enviar email de reserva cancelada', [
                'reserva_id' => $this->reservation->id,
                'email' => $this->reservation->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::critical('Job de email de reserva cancelada falló definitivamente', [
            'reserva_id' => $this->reservation->id,
            'email' => $this->reservation->email,
            'error' => $exception->getMessage(),
        ]);
    }
}
