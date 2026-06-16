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
        $data = $request->validate([
            'nombre_cargo' => 'required|string|max:255',
            'salario_base' => 'required|numeric|min:0',
            'estado'       => 'required|in:activo,inactivo',
        ]);

        $cargo = Cargo::create($data);

        return response()->json($cargo, 201);
    }

    public function show(Cargo $cargo)
    {
        return response()->json($cargo, 200);
    }

    public function update(Request $request, Cargo $cargo)
    {
        $data = $request->validate([
            'nombre_cargo' => 'sometimes|required|string|max:255',
            'salario_base' => 'sometimes|required|numeric|min:0',
            'estado'       => 'sometimes|required|in:activo,inactivo',
        ]);

        $cargo->update($data);

        return response()->json($cargo, 200);
    }

    public function destroy(Cargo $cargo)
    {
        $cargo->delete();

        return response()->json(['message' => 'Cargo eliminado correctamente'], 200);
    }
}