<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    //use HasFactory;

    protected $table='abonos';
    protected $primaryKey='idAbono';
    public $timestamps=false;

    protected $fillable = [
        'idTarjeta','numCuota','valorAbono','fechaAbono'
    ];
}
