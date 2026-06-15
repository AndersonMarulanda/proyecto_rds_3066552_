<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuncionCargo extends Model
{
    protected $table = 'funciones_cargo';

    protected $primaryKey = 'id_funcion';

    protected $fillable = [
        'descripcion_funcion',
        'estado',
        'id_cargo'
    ];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'id_cargo');
    }
}