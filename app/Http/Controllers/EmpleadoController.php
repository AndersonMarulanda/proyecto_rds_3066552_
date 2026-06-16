<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        return response()->json(Empleado::with('cargo')->get(), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombres'          => 'required|string|max:255',
            'apellidos'        => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'fecha_ingreso'    => 'required|date',
            'salario'          => 'required|numeric|min:0',
            'estado'           => 'required|in:activo,inactivo',
            'id_cargo'         => 'required|exists:cargos,id',
        ]);

        $empleado = Empleado::create($data);

        return response()->json($empleado->load('cargo'), 201);
    }

    public function show(Empleado $empleado)
    {
        return response()->json($empleado->load('cargo'), 200);
    }

    public function update(Request $request, Empleado $empleado)
    {
        $data = $request->validate([
            'nombres'          => 'sometimes|required|string|max:255',
            'apellidos'        => 'sometimes|required|string|max:255',
            'fecha_nacimiento' => 'sometimes|required|date',
            'fecha_ingreso'    => 'sometimes|required|date',
            'salario'          => 'sometimes|required|numeric|min:0',
            'estado'           => 'sometimes|required|in:activo,inactivo',
            'id_cargo'         => 'sometimes|required|exists:cargos,id',
        ]);

        $empleado->update($data);

        return response()->json($empleado->load('cargo'), 200);
    }

    public function destroy(Empleado $empleado)
    {
        $empleado->delete();

        return response()->json(['message' => 'Empleado eliminado correctamente'], 200);
    }
}