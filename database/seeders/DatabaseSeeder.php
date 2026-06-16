<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cargo;
use App\Models\Empleado;
use App\Models\FuncionCargo;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 5 cargos, cada uno con 2 funciones y 3 empleados
        Cargo::factory()
            ->count(5)
            ->has(FuncionCargo::factory()->count(2), 'funciones')
            ->has(Empleado::factory()->count(3), 'empleados')
            ->create();
    }
}