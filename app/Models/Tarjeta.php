<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
    protected $table='tarjetas';
    protected $primaryKey='idTarjeta';
    public $timestamps=false;

    protected $fillable = [
        'idCliente','valorPrestado','valorTotal','fechaPrestamo',
        'numCuotas','idEstado','interes','valorDefecto','fecActu'
    ];

}
