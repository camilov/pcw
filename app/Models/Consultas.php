<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultas extends Model
{
    //use HasFactory;

	protected $table='totales';
    protected $primaryKey='idTotal';
    public $timestamps=false;

    protected $fillable = [
        'totalCapital','totalInteres','gananciaC','gananciaW','totalPrestado','totalPagado'
    ];
}
