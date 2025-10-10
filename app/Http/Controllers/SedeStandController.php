<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use App\Models\SedeStand;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SedeStandController
{
    public function listView($sedeId)
    {
        $sede = Sede::with(['sedeStands.stand'])->findOrFail($sedeId);

        $availableDates = [];
        $today = Carbon::now('America/Lima');

        while (count($availableDates) < 4) {
            if ($today->isWeekend()) {
                $availableDates[] = $today->copy();
            }
            $today->addDay();
        }

        $selectedDate = request('fecha') ?? $availableDates[0]->toDateString();

        return view('sedes.stands', compact('sede', 'availableDates', 'selectedDate'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $sedeStand = SedeStand::create($request->validate([
            'sede_id'  => 'required|integer|exists:sedes,id',
            'stand_id' => 'required|integer|exists:stands,id',
            'price'    => 'required|numeric|min:0',
        ]));

        return response()->json($sedeStand, 201);
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
    }

    public function update(Request $request, SedeStand $sedeStand)
    {
        $sedeStand->update($request->validate([
            'price' => 'required|numeric|min:0',
        ]));

        return response()->json($sedeStand);
    }

    public function destroy(SedeStand $sedeStand)
    {
        $sedeStand->delete();
        return response()->json(null, 204);
    }
}
