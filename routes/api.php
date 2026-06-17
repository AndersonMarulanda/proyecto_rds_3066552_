<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\FuncionCargoController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('cargos', CargoController::class);
    Route::get('cargos/{cargo}/funciones', [CargoController::class, 'funciones']);

    Route::apiResource('empleados', EmpleadoController::class);
    Route::apiResource('funciones', FuncionCargoController::class)
        ->parameters(['funciones' => 'funcionCargo']);
});