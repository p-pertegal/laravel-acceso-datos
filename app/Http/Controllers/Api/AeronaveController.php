<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aeronave;

class AeronaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Aeronave:all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $aeronave = Aeronave::create($request->all());
	return response()->json($aeronave, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Aeronave $aeronave)
    {
        return $aeronave;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aeronave $aeronave)
    {
        $aeronave->update($request->all());
	return response()->json($aeronave);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aeronave $aeronave)
    {
        $aeronave->delete();
	return respose()->json(null, 204);
    }
}
