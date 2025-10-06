<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\SedeStand;
use Illuminate\Http\Client\Request;
use Illuminate\Routing\Controller;

class ReservationController extends Controller
{
    //
    public function create(Request $request)
    {
        $sedeStand = SedeStand::with(['stand', 'sede'])->findOrFail($request->sede_stand_id);
        $fecha = $request->fecha;

        return view('reservas.create', compact('sedeStand', 'fecha'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sede_stand_id' => 'required|exists:sede_stands,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'name' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
        ], [
            'terms.accepted' => 'Debes aceptar los términos y condiciones.',
            'captcha.in' => 'El captcha ingresado es incorrecto.'
        ]);

        // try {
        //     return DB::transaction(function() use ($data) {
        //         // lock fila para evitar concurrencia
        //         $sedeStand = SedeStand::where('id', $data['sede_stand_id'])->lockForUpdate()->firstOrFail();

        //         // consulta de disponibilidad (dentro de la transacción)
        //         $exists = Reserva::where('sede_stand_id', $sedeStand->id)
        //             ->where('reservation_date', $data['reservation_date'])
        //             ->whereIn('status', [Reserva::STATUS_PENDING, Reserva::STATUS_PAID])
        //             ->exists();

        //         if ($exists) {
        //             return response()->json(['message' => 'Stand no disponible en esa fecha'], 422);
        //         }

        //         // crear reserva
        //         $reserva = Reserva::create([
        //             'sede_stand_id' => $sedeStand->id,
        //             'reservation_date' => $data['reservation_date'],
        //             'price' => $sedeStand->price,
        //             'status' => Reserva::STATUS_PENDING,
        //             'name' => $data['name'] ?? null,
        //             'surname' => $data['surname'] ?? null,
        //             'email' => $data['email'] ?? null,
        //             'phone' => $data['phone'] ?? null,
        //         ]);

        //         return response()->json($reserva, 201);
        //     });
        // } catch (\Exception $e) {
        //     // manejar excepciones (unique constraint, DB errors, etc.)
        //     return response()->json(['message' => 'Error al crear reserva', 'error' => $e->getMessage()], 500);
        // }

        return back()->with('success', 'Formulario validado correctamente. Próximamente guardaremos la reserva.');
    }

    // API simple para chequear disponibilidad
    public function checkAvailability(Request $request)
    {
        // $request->validate(['sede_stand_id' => 'required|exists:sede_stands,id', 'date' => 'required|date']);
        // $available = Reserva::isAvailable($request->sede_stand_id, $request->date);
        // return response()->json(['available' => $available]);
    }
}
