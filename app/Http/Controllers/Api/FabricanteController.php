<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fabricante;

class FabricanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Fabricante::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fabricante = Fabricante::create($request->all());
	return response()->json($fabricante, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Fabricante $fabricante)
    {
        return $fabricante;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fabricante $fabricante)
    {
        $fabricante->update($request->all());
	return response()->json($fabricante);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fabricante $fabricante)
    {
        $fabricante->delete();
	return response()->json(null, 204);
    }
}
