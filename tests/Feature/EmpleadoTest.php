<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cargo;

class EmpleadoTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_empleado()
    {
        $cargo = Cargo::factory()->create();

        $response = $this->postJson('/api/empleados', [
            'nombres' => 'Juan',
            'apellidos' => 'Perez',
            'fecha_nacimiento' => '2000-01-01',
            'fecha_ingreso' => '2026-01-01',
            'salario' => 2000000,
            'estado' => 'activo',
            'id_cargo' => $cargo->id,
        ]);

        $response->assertStatus(201);
    }
}