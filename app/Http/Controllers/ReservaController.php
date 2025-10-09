<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservaRequest;
use App\Jobs\SendAddedReservationEmail;
use App\Jobs\SendCancelledReservationEmail;
use App\Jobs\SendPaidReservationEmail;
use App\Models\Reserva;
use App\Models\SedeStand;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservaController
{
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
            $sedeStand = SedeStand::where('id', $request->sede_stand_id)->lockForUpdate()->firstOrFail();
            
            if (!$sedeStand->isAvailableOn($request->reservation_date)) {
                return back()->withErrors([
                    'stand_id' => 'Este stand ya ha sido reservado para la fecha seleccionada.'
                ])->withInput();
            }

            if(!$sedeStand->hasValidPrice()) {
                return back()->withErrors(['stand_id', 'El stand seleccionado no tiene un precio válido configurado.'])->withInput();
            }

            $reservation = Reserva::create([
                'sede_stand_id' => $sedeStand->id,
                'reservation_date' => $request->reservation_date,
                'price' => $sedeStand->price,
                'status' => Reserva::STATUS_PENDING,
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            $reservation->load('sedeStand.sede', 'sedeStand.stand');
            $this->dispatchNotificationEmail($reservation, Reserva::STATUS_PENDING);
            
            DB::commit();

            Log::info('Reserva creada exitosamente', [
                'reserva_id' => $reservation->id,
                'key_code' => $reservation->key_code,
                'sede_stand_id' => $sedeStand->id,
            ]);

            return redirect()->route('reservas.success', ['reserva' => $reservation->id])->with('success', 'Reserva registrada correctamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            Log::warning('Stand no encontrado al crear reserva', [
                'sede_stand_id' => $request->sede_stand_id,
            ]);
    
            return back()
                ->withErrors(['stand_id' => 'El stand seleccionado no existe.'])
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar reserva', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'user_data' => $request->only(['name', 'email', 'sede_stand_id', 'reservation_date']),
            ]);
            return back()->withErrors(['error' => 'No se pudo completar la reserva. Por favor, inténtelo nuevamente.'])->withInput();
        }
    }

    public function verify(string $keyCode)
    {
        $reservation = Reserva::findByKeyCode($keyCode);

        if(!$reservation) {
            return back()->withErrors([
                'code' => 'Código clave no válido'
            ]);
        }
        return redirect()->route('admin.index')->with('success', 'Estado actualizado correctamente.');
    }

    public function success($id)
    {
        $reserva = Reserva::with('sedeStand.stand', 'sedeStand.sede')->findOrFail($id);
        return view('reservas.success', compact('reserva'));
    }

    public function adminIndex() {
        $reservas = Reserva::with(['sedeStand.stand', 'sedeStand.sede'])->orderBy('reservation_date', 'desc')->get();

        return view('admin.index', ['reservas' => $reservas, 'statuses' => Reserva::selectableStatuses()]);
    }

    public function updateStatus(Request $request, Reserva $reservation)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,canceled',
        ]);

        $newStatus = $validated['status'];

        try {
            DB::beginTransaction();

            $reservation->update(['status' => $newStatus]);
            $reservation->refresh();
            $reservation->load('sedeStand.sede', 'sedeStand.stand');

            $this->dispatchNotificationEmail($reservation, $newStatus);
            DB::commit();

            Log::info('Estado de reserva actualizado', [
                'reserva_uuid' => $reservation->id,
                'key_code' => $reservation->key_code,
                'sede_stand_id' => $reservation->sedeStand->id,
            ]);

            return redirect()->route('admin.index')->with('success', 'Estado actualizado correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Error al enviar correo de confirmación de reserva', [
                'exception' => $e,
                'reserva_id' => $reservation->id,
                'email' => $reservation->email,
            ]);

            return redirect()->route('admin.index')->with('warning', 'El estado fue actualizado, pero no se pudo enviar el correo al cliente.');
        }
    }

    public function dispatchNotificationEmail(Reserva $reservation, string $status): void {
        match($status) {
            Reserva::STATUS_PENDING => SendAddedReservationEmail::dispatch($reservation),
            Reserva::STATUS_PAID => SendPaidReservationEmail::dispatch($reservation),
            Reserva::STATUS_CANCELED => SendCancelledReservationEmail::dispatch($reservation),
            default => Log::warning('Estado no reconocido para envío de email', [
                'status' => $status,
                'reserva_id' => $reservation->id,
            ]),
        };
    }
}
