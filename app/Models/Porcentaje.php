<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Porcentaje extends Model
{
   
	protected $table='porcentajes';
    protected $primaryKey='idPorcentaje';
    public $timestamps=false;

    protected $fillable = [
        'porcentaje'
    ];
   // use HasFactory;
}
