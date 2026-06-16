<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function index()
    {
        return response()->json(Cargo::all(), 200);
    }

    public function store(Request $request)
    {
        $cargo = Cargo::create([
            'nombre_cargo' => $request->nombre_cargo,
            'salario_base' => $request->salario_base,
            'estado'       => $request->estado,
        ]);

        return response()->json($cargo, 201);
    }

    public function show(Cargo $cargo)
    {
        return response()->json($cargo, 200);
    }

    public function update(Request $request, Cargo $cargo)
    {
        $cargo->update([
            'nombre_cargo' => $request->nombre_cargo,
            'salario_base' => $request->salario_base,
            'estado'       => $request->estado,
        ]);

        return response()->json($cargo, 200);
    }

    public function destroy(Cargo $cargo)
    {
        $cargo->delete();
        return response()->json(['message' => 'Cargo eliminado correctamente'], 200);
    }
}
