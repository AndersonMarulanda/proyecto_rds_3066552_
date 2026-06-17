<?php
 
namespace App\Http\Controllers;
 
use App\Models\FuncionCargo;
use Illuminate\Http\Request;
 
class FuncionCargoController extends Controller
{
    public function index()
    {
        $funciones = FuncionCargo::with('cargo')->get();
 
        if ($funciones->isEmpty()) {
            return response()->json(['message' => 'No se encontraron funciones registradas'], 200);
        }
 
        return response()->json($funciones, 200);
    }
 
    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion_funcion' => 'required|string',
            'estado'              => 'required|in:activo,inactivo',
            'id_cargo'            => 'required|exists:cargos,id',
        ]);
 
        $funcion = FuncionCargo::create($data);
 
        return response()->json($funcion->load('cargo'), 201);
    }
 
    public function show(FuncionCargo $funcionCargo)
    {
        return response()->json($funcionCargo->load('cargo'), 200);
    }
 
    public function update(Request $request, FuncionCargo $funcionCargo)
    {
        $data = $request->validate([
            'descripcion_funcion' => 'sometimes|required|string',
            'estado'              => 'sometimes|required|in:activo,inactivo',
            'id_cargo'            => 'sometimes|required|exists:cargos,id',
        ]);
 
        $funcionCargo->update($data);
 
        return response()->json($funcionCargo->load('cargo'), 200);
    }
 
    public function destroy(FuncionCargo $funcionCargo)
    {
        $funcionCargo->delete();
 
        return response()->json(['message' => 'Función eliminada correctamente'], 200);
    }
}