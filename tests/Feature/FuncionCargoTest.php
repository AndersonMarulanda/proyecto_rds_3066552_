<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cargo;
use App\Models\FuncionCargo;
use App\Models\User;

class FuncionCargoTest extends TestCase
{
    use RefreshDatabase;

    private function usuario()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        return ['Authorization' => "Bearer $token"];
    }

    private function cargoValido(): Cargo
    {
        return Cargo::factory()->create();
    }

    public function test_puede_crear_funcion()
    {
        $cargo = $this->cargoValido();

        $response = $this->postJson('/api/funciones', [
            'descripcion_funcion' => 'Gestionar equipo de desarrollo',
            'estado'              => 'activo',
            'id_cargo'            => $cargo->id,
        ], $this->usuario());

        $response->assertStatus(201)
                 ->assertJsonFragment(['descripcion_funcion' => 'Gestionar equipo de desarrollo']);
    }

    public function test_no_puede_crear_funcion_sin_datos_requeridos()
    {
        $response = $this->postJson('/api/funciones', [], $this->usuario());

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['descripcion_funcion', 'estado', 'id_cargo']);
    }

    public function test_no_puede_crear_funcion_con_cargo_inexistente()
    {
        $response = $this->postJson('/api/funciones', [
            'descripcion_funcion' => 'Revisar código',
            'estado'              => 'activo',
            'id_cargo'            => 9999,
        ], $this->usuario());

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['id_cargo']);
    }

    public function test_puede_listar_funciones()
    {
        FuncionCargo::factory()->count(3)->create();

        $response = $this->getJson('/api/funciones', $this->usuario());

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_puede_ver_una_funcion()
    {
        $funcion = FuncionCargo::factory()->create();

        $response = $this->getJson("/api/funciones/{$funcion->id}", $this->usuario());

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $funcion->id]);
    }

    public function test_puede_actualizar_funcion()
    {
        $funcion = FuncionCargo::factory()->create();

        $response = $this->putJson("/api/funciones/{$funcion->id}", [
            'descripcion_funcion' => 'Nueva descripción actualizada',
        ], $this->usuario());

        $response->assertStatus(200)
                 ->assertJsonFragment(['descripcion_funcion' => 'Nueva descripción actualizada']);
    }

    public function test_puede_eliminar_funcion()
    {
        $funcion = FuncionCargo::factory()->create();

        $response = $this->deleteJson("/api/funciones/{$funcion->id}", [], $this->usuario());

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Función eliminada correctamente']);

        $this->assertDatabaseMissing('funciones_cargo', ['id' => $funcion->id]);
    }
}