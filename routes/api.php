<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\FuncionCargoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('cargos', CargoController::class);
Route::apiResource('empleados', EmpleadoController::class);
Route::apiResource('funciones', FuncionCargoController::class)
    ->parameters(['funciones' => 'funcionCargo']);