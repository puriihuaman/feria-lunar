<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservaRequest;
use App\Jobs\SendCancelledReservationEmail;
use App\Jobs\SendPaidReservationEmail;
use App\Mail\PaidReservationMail;
use App\Mail\ReservaCreadaMail;
use App\Models\Reserva;
use App\Models\SedeStand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ReservaController
{
    //
    public function create(Request $request)
    {
        $sedeStand = SedeStand::with(['stand', 'sede'])->findOrFail($request->sede_stand_id);
        $selectedDate = $request->selected_date;

        return view('reservas.create', compact('sedeStand', 'selectedDate'));
    }

    public function store(StoreReservaRequest $request)
    {
        DB::beginTransaction();
        try {
            // lock fila para evitar concurrencia
            $sedeStand = SedeStand::where('id', $request->sede_stand_id)->lockForUpdate()->firstOrFail();

            // consulta de disponibilidad (dentro de la transacción)
            $exists = Reserva::where('sede_stand_id', $sedeStand->id)
                ->where('reservation_date', $request->reservation_date)
                ->whereIn('status', [Reserva::STATUS_PENDING, Reserva::STATUS_PAID])
                ->exists();

            if ($exists) {
                return back()->withErrors([
                    'stand_id' => 'Este stand ya ha sido reservado para la fecha seleccionada.'
                ])->withInput();
            }

            // crear reserva
            $reserva = Reserva::create([
                'sede_stand_id' => $sedeStand->id,
                'reservation_date' => $request->reservation_date,
                'price' => $sedeStand->price,
                'status' => Reserva::STATUS_PENDING,
                'name' => $request['name'] ?? null,
                'surname' => $request['surname'] ?? null,
                'email' => $request['email'] ?? null,
                'phone' => $request['phone'] ?? null,
            ]);
            DB::commit();
            Mail::to($reserva->email)->send(new ReservaCreadaMail($reserva->load('sedeStand.sede', 'sedeStand.stand')));
            // Mail::to($reserva->email)->send(new ReservaCreadaMail($reserva));

            return redirect()->route('reservas.success', ['reserva' => $reserva->id])->with('success', 'Reserva registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar reserva', [
                'exception' => $e,
                'user_data' => $request->only(['name', 'email', 'sede_stand_id', 'reservation_date']),
            ]);
            return back()->withErrors(['error' => 'No se pudo completar la reserva. Por favor, inténtelo nuevamente o contacte con soporte.'])->withInput();
        }

    }

    // Vista de éxito
    public function success($id)
    {
        $reserva = Reserva::with('sedeStand.stand', 'sedeStand.sede')->findOrFail($id);
        return view('reservas.success', compact('reserva'));
    }

    // API simple para chequear disponibilidad
    public function checkAvailability(Request $request)
    {
        // $request->validate(['sede_stand_id' => 'required|exists:sede_stands,id', 'date' => 'required|date']);
        // $available = Reserva::isAvailable($request->sede_stand_id, $request->date);
        // return response()->json(['available' => $available]);
    }

    public function adminIndex() {
        // $reservas = Reserva::with(['sedeStand.stand', 'user', 'sedeStand.sede'])
        //     ->orderBy('reservation_date', 'desc')
        //     ->get();

        // return view('admin.index', compact('reservas'));

        $reservas = Reserva::with(['sedeStand.stand', 'sedeStand.sede'])->orderBy('reservation_date', 'desc')->get();

        return view('admin.index', compact('reservas'));
    }

    public function updateStatus(Request $request, Reserva $reserva)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,cancelled',
        ]);

        $oldStatus = $reserva->status;
        $newStatus = $validated['status'];

        try {
            DB::beginTransaction();

            $reserva->update(['status' => $newStatus]);

            $this->dispatchNotificationEmail($reserva, $newStatus);
            DB::commit();

            Log::info('Estado de reserva actualizado', [
                'reserva_id' => $reserva->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ]);

            return redirect()->route('admin.index')->with('success', 'Estado actualizado correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Error al enviar correo de confirmación de reserva', [
                'exception' => $e,
                'reserva_id' => $reserva->id,
                'email' => $reserva->email,
            ]);

            return redirect()->route('admin.index')->with('warning', 'El estado fue actualizado, pero no se pudo enviar el correo al cliente.');
        }
    }

    public function dispatchNotificationEmail(Reserva $reservation, string $status): void {
        match($status) {
            Reserva::STATUS_PAID => SendPaidReservationEmail::dispatch($reservation),
            Reserva::STATUS_CANCELED => SendCancelledReservationEmail::dispatch($reservation),
            default => null, // PENDING no envía email
        };
        // if ($reservation->status === Reserva::STATUS_PAID) {
        //     Mail::to($reservation->email)->send(new PaidReservationMail($reservation));
        // }
    }
}
