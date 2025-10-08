<?php

namespace App\Jobs;

use App\Mail\PaidReservationMail;
use App\Models\Reserva;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPaidReservationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3; // Reintentar 3 veces si falla
    public $timeout = 30; // Timeout de 30 segundos

    /**
     * Create a new job instance.
     */
    public function __construct(public Reserva $reservation)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        try {
            Mail::to($this->reservation->email)->send(new PaidReservationMail($this->reservation));
            
            Log::info('Email de reserva pagada enviado', [
                'reserva_id' => $this->reservation->id,
                'email' => $this->reservation->email,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error al enviar email de reserva pagada', [
                'reserva_id' => $this->reservation->id,
                'email' => $this->reservation->email,
                'error' => $e->getMessage(),
            ]);
            
            // Lanzar excepción para que Laravel reintente el job
            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        // Se ejecuta después de agotar todos los reintentos
        Log::critical('Job de email de reserva pagada falló definitivamente', [
            'reserva_id' => $this->reservation->id,
            'email' => $this->reservation->email,
            'error' => $exception->getMessage(),
        ]);
    }
}
