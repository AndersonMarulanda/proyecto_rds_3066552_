<?php
 
namespace App\Http\Controllers;
 
use App\Models\Empleado;
use Illuminate\Http\Request;
 
class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::with('cargo')->get();
 
        if ($empleados->isEmpty()) {
            return response()->json(['message' => 'No se encontraron empleados registrados'], 200);
        }
 
        return response()->json($empleados, 200);
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
        $empleado->load('cargo.funciones');
 
        return response()->json([
            'id'       => $empleado->id,
            'nombre'   => $empleado->nombres . ' ' . $empleado->apellidos,
            'salario'  => $empleado->salario,
            'estado'   => $empleado->estado,
            'cargo'    => [
                'id'           => $empleado->cargo->id,
                'nombre_cargo' => $empleado->cargo->nombre_cargo,
                'salario_base' => $empleado->cargo->salario_base,
            ],
            'funciones' => $empleado->cargo->funciones->map(fn($f) => [
                'id'                  => $f->id,
                'descripcion_funcion' => $f->descripcion_funcion,
                'estado'              => $f->estado,
            ]),
        ], 200);
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