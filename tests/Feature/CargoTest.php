<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CargoTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_cargo()
    {
        $response = $this->postJson('/api/cargos', [
            'nombre_cargo' => 'Desarrollador',
            'salario_base' => 3000000,
            'estado' => 'activo',
        ]);

        $response->assertStatus(201);
    }
}