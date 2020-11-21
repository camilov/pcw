<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
   // use HasFactory;

	protected $table='clientes';
    protected $primaryKey='idCliente';
    public $timestamps=false;

    protected $fillable = [
        'nombre'
    ];

    public function scopeSearch($query,$nombre)
    {
        return $query->where('nombre', 'LIKE', "%$nombre%");
    }
}
