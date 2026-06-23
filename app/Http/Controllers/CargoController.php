<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function index()
    {
        $cargos = Cargo::paginate(10);

        return response()->json($cargos, 200);
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

    public function show($id)
    {
        $cargo = Cargo::find($id);

        if (!$cargo) {
            return response()->json([
                'message' => 'CARGO INEXISTENTE'
            ], 404);
        }

        return response()->json($cargo, 200);
    }

    public function update(Request $request, $id)
    {
        $cargo = Cargo::find($id);

        if (!$cargo) {
            return response()->json([
                'message' => 'CARGO INEXISTENTE'
            ], 404);
        }

        $data = $request->validate([
            'nombre_cargo' => 'sometimes|required|string|max:255',
            'salario_base' => 'sometimes|required|numeric|min:0',
            'estado'       => 'sometimes|required|in:activo,inactivo',
        ]);

        $cargo->update($data);

        return response()->json([
            'message' => 'Cargo actualizado correctamente',
            'cargo' => $cargo
        ], 200);
    }

    public function destroy($id)
    {
        $cargo = Cargo::find($id);

        if (!$cargo) {
            return response()->json([
                'message' => 'CARGO INEXISTENTE'
            ], 404);
        }

        $cargo->delete();

        return response()->json([
            'message' => 'Cargo eliminado correctamente'
        ], 200);
    }

    public function funciones($id)
    {
        $cargo = Cargo::with('funciones')->find($id);

        if (!$cargo) {
            return response()->json([
                'message' => 'CARGO INEXISTENTE'
            ], 404);
        }

        return response()->json($cargo->funciones, 200);
    }
}