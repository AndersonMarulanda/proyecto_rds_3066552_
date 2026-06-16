<?php

namespace App\Http\Controllers;

use App\Models\FuncionCargo;
use Illuminate\Http\Request;

class FuncionCargoController extends Controller
{
    /**
     * Mostrar todas las funciones.
     */
    public function index()
    {
        return response()->json(
            FuncionCargo::with('cargo')->get(),
            200
        );
    }

    /**
     * Crear una nueva función.
     */
    public function store(Request $request)
    {
        $funcion = FuncionCargo::create([
            'descripcion_funcion' => $request->descripcion_funcion,
            'estado' => $request->estado,
            'id_cargo' => $request->id_cargo,
        ]);

        return response()->json($funcion, 201);
    }

    /**
     * Mostrar una función específica.
     */
    public function show(FuncionCargo $funcionCargo)
    {
        return response()->json(
            $funcionCargo->load('cargo'),
            200
        );
    }

    /**
     * Actualizar una función.
     */
    public function update(Request $request, FuncionCargo $funcionCargo)
    {
        $funcionCargo->update([
            'descripcion_funcion' => $request->descripcion_funcion,
            'estado' => $request->estado,
            'id_cargo' => $request->id_cargo,
        ]);

        return response()->json($funcionCargo, 200);
    }

    /**
     * Eliminar una función.
     */
    public function destroy(FuncionCargo $funcionCargo)
    {
        $funcionCargo->delete();

        return response()->json([
            'message' => 'Función eliminada correctamente'
        ], 200);
    }
}