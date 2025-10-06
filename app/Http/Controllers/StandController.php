<?php

namespace App\Http\Controllers;

use App\Models\Stand;
use Illuminate\Http\Request;

class StandController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stands = Stand::all();
        // return view('stand.index', compact('stands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $stand = Stand::create($request->validate([
            'booth_number' => 'required|integer|unique:stands',
            'category'     => 'required|string',
            'description'  => 'nullable|string',
        ]));

        return response()->json($stand, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json($id);
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
    public function update(Request $request, Stand $stand)
    {
        //
        $stand->update($request->validate([
            'category'    => 'string',
            'description' => 'nullable|string',
        ]));

        return response()->json($stand);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stand $stand)
    {
        //
        $stand->delete();
        return response()->json(null, 204);
    }
}
