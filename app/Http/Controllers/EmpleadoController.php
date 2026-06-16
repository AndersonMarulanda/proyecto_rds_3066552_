<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'fecha_nacimiento' => 'required',
            'fecha_ingreso' => 'required',
            'salario' => 'required',
            'estado' => 'required',
            'id_cargo' => 'required|exists:cargos,id',
        ]);

        $empleado = Empleado::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'fecha_ingreso' => $request->fecha_ingreso,
            'salario' => $request->salario,
            'estado' => $request->estado,
            'id_cargo' => $request->id_cargo,
        ]);

        return response()->json($empleado, 201);
    }
}