<?php

namespace Database\Factories;

use App\Models\Cargo;
use App\Models\FuncionCargo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FuncionCargo>
 */
class FuncionCargoFactory extends Factory
{
    protected $model = FuncionCargo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descripcion_funcion' => fake()->sentence(),
            'estado' => fake()->randomElement(['Activo', 'Inactivo']),
            'id_cargo' => Cargo::factory(),
        ];
    }
}