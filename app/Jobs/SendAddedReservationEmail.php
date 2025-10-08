<?php

namespace App\Jobs;

use App\Mail\ReservaCreadaMail;
use App\Models\Reserva;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendAddedReservationEmail implements ShouldQueue
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
            
            Mail::to($reservation->email)->send(new ReservaCreadaMail($reservation));

            Log::info('Email de reserva agendada enviado', [
                'reserva_id' => $reservation->id,
                'email' => $reservation->email
            ]);
        } catch (\Throwable $e) {
            Log::error('Error al enviar email de reserva agendada', [
                'reserva_id' => $this->reservation->id,
                'email' => $this->reservation->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    public function failed(\Throwable $e) {
        Log::critical('Job de email de reserva agendada falló definitivamente', [
            'reserva_id' => $this->reservation->id,
            'email' => $this->reservation->email,
            'error' => $e->getMessage()
        ]);
    }
}
