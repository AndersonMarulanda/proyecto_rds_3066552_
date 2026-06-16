<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cargo;

class CargoTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_cargo()
    {
        $response = $this->postJson('/api/cargos', [
            'nombre_cargo' => 'Desarrollador',
            'salario_base' => 3000000,
            'estado'       => 'activo',
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['nombre_cargo' => 'Desarrollador']);
    }

    public function test_no_puede_crear_cargo_sin_datos_requeridos()
    {
        $response = $this->postJson('/api/cargos', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre_cargo', 'salario_base', 'estado']);
    }

    public function test_puede_listar_cargos()
    {
        Cargo::factory()->count(3)->create();

        $response = $this->getJson('/api/cargos');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_puede_ver_un_cargo()
    {
        $cargo = Cargo::factory()->create();

        $response = $this->getJson("/api/cargos/{$cargo->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $cargo->id]);
    }

    public function test_puede_actualizar_cargo()
    {
        $cargo = Cargo::factory()->create();

        $response = $this->putJson("/api/cargos/{$cargo->id}", [
            'nombre_cargo' => 'Senior Developer',
            'salario_base' => 5000000,
            'estado'       => 'activo',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nombre_cargo' => 'Senior Developer']);
    }

    public function test_puede_eliminar_cargo()
    {
        $cargo = Cargo::factory()->create();

        $response = $this->deleteJson("/api/cargos/{$cargo->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Cargo eliminado correctamente']);

        $this->assertDatabaseMissing('cargos', ['id' => $cargo->id]);
    }
}