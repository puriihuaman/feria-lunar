<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use App\Models\SedeStand;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SedeStandController
{
    /**
     * Display a listing of the resource.
     */
    public function listView($sedeId)
    {
        //
        $sede = Sede::with(['sedeStands.stand'])->findOrFail($sedeId);

        // Obtener las próximas 4 fechas (sábados y domingos)
        $availableDates = [];
        $today = Carbon::now('America/Lima');
        $contador = 0;

        while (count($availableDates) < 4) {
            if ($today->isWeekend()) {
                $availableDates[] = $today->copy();
            }
            $today->addDay();
        }

        // Si no hay "fecha" en la request, usamos la primera
        $selectedDate = request('fecha') ?? $availableDates[0]->toDateString();

        return view('sedes.stands', compact('sede', 'availableDates', 'selectedDate'));

        //$stands = SedeStand::where('sede_id', $sedeId)->with('stand')->get();
        //return view('sedes.stands', compact('stands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $sedeStand = SedeStand::create($request->validate([
            'sede_id'  => 'required|integer|exists:sedes,id',
            'stand_id' => 'required|integer|exists:stands,id',
            'price'    => 'required|numeric|min:0',
        ]));

        return response()->json($sedeStand, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SedeStand $sedeStand)
    {
        //
        $sedeStand->update($request->validate([
            'price' => 'required|numeric|min:0',
        ]));

        return response()->json($sedeStand);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SedeStand $sedeStand)
    {
        //
        $sedeStand->delete();
        return response()->json(null, 204);
    }
}
