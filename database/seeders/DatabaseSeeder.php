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
        
        $cargos = Cargo::factory()
            ->count(40)
            ->has(FuncionCargo::factory()->count(5), 'funciones')
            ->create();

        
        $cargos->each(function ($cargo, $index) {
            if ($index < 30) {
                Empleado::factory()->create(['id_cargo' => $cargo->id]);
            }
        });
    }
}