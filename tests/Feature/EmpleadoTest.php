<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cargo;
use App\Models\Empleado;

class EmpleadoTest extends TestCase
{
    use RefreshDatabase;

    private function cargoValido(): Cargo
    {
        return Cargo::factory()->create();
    }

    private function datosEmpleado(int $idCargo): array
    {
        return [
            'nombres'          => 'Juan',
            'apellidos'        => 'Pérez',
            'fecha_nacimiento' => '1995-05-20',
            'fecha_ingreso'    => '2024-01-15',
            'salario'          => 2500000,
            'estado'           => 'activo',
            'id_cargo'         => $idCargo,
        ];
    }

    public function test_puede_crear_empleado()
    {
        $cargo = $this->cargoValido();

        $response = $this->postJson('/api/empleados', $this->datosEmpleado($cargo->id));

        $response->assertStatus(201)
                 ->assertJsonFragment(['nombres' => 'Juan']);
    }

    public function test_no_puede_crear_empleado_sin_datos_requeridos()
    {
        $response = $this->postJson('/api/empleados', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                     'nombres', 'apellidos', 'fecha_nacimiento',
                     'fecha_ingreso', 'salario', 'estado', 'id_cargo',
                 ]);
    }

    public function test_no_puede_crear_empleado_con_cargo_inexistente()
    {
        $response = $this->postJson('/api/empleados', $this->datosEmpleado(9999));

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['id_cargo']);
    }

    public function test_puede_listar_empleados()
    {
        Empleado::factory()->count(2)->create();

        $response = $this->getJson('/api/empleados');

        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }

    public function test_puede_ver_un_empleado()
    {
        $empleado = Empleado::factory()->create();

        $response = $this->getJson("/api/empleados/{$empleado->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $empleado->id]);
    }

    public function test_puede_actualizar_empleado()
    {
        $empleado = Empleado::factory()->create();

        $response = $this->putJson("/api/empleados/{$empleado->id}", [
            'nombres'   => 'Carlos',
            'apellidos' => 'González',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nombres' => 'Carlos']);
    }

    public function test_puede_eliminar_empleado()
    {
        $empleado = Empleado::factory()->create();

        $response = $this->deleteJson("/api/empleados/{$empleado->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Empleado eliminado correctamente']);

        $this->assertDatabaseMissing('empleados', ['id' => $empleado->id]);
    }
}