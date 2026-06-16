<?php

namespace Database\Factories;

use App\Models\Cargo;
use Illuminate\Database\Eloquent\Factories\Factory;

class CargoFactory extends Factory
{
    protected $model = Cargo::class;

    public function definition(): array
    {
        return [
            'nombre_cargo' => fake()->jobTitle(),
            'salario_base' => fake()->numberBetween(1500000, 5000000),
            'estado' => fake()->randomElement(['activo', 'inactivo']),
        ];
    }
}
