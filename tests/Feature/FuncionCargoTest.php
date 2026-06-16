<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cargo;

class FuncionCargoTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_funcion()
    {
        $cargo = Cargo::factory()->create();

        $this->assertDatabaseHas('cargos', [
            'id' => $cargo->id
        ]);

        $response = $this->postJson('/api/funciones', [
            'descripcion_funcion' => 'Gestionar equipo',
            'estado' => 'activo',
            'id_cargo' => $cargo->id,
        ]);

        $response->assertStatus(201);
    }
}