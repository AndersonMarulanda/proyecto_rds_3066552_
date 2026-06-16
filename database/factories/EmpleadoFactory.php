<?php

namespace Database\Factories;

use App\Models\Cargo;
use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Empleado>
 */
class EmpleadoFactory extends Factory
{
    protected $model = Empleado::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombres' => fake()->firstName(),
            'apellidos' => fake()->lastName(),
            'fecha_nacimiento' => fake()->date(),
            'fecha_ingreso' => fake()->date(),
            'salario' => fake()->numberBetween(1500000, 5000000),
            'estado' => fake()->randomElement(['Activo', 'Inactivo']),
            'id_cargo' => Cargo::factory(),
        ];
    }
}