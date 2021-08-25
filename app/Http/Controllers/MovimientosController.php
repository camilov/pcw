<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use Illuminate\Support\Facades\DB;


class MovimientosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        //dd($request->fecha);
        $movimiento = DB::table('movimientos')
                      ->join('tipomovimiento','tipomovimiento.tipMvto', '=','movimientos.tipMvto')
                      ->join('clientes','clientes.idCliente', '=','movimientos.idCliente')
                      ->select('entrada','salida','tipomovimiento.nomMvto as nomMvto','idTarjeta','clientes.nombre as nombre','fecMvto')
                      ->where('movimientos.fecMvto',$request->fecha)
                     // ->orWhere('movimientos.fecMvto','is not null')
                      ->orderBy('fecMvto','desc')
                      ->paginate(10);

        $interes = DB::table('movimientos')
                   ->where('movimientos.tipMvto','=','PI')
                   ->where('movimientos.fecMvto',$request->fecha)
                   ->sum('movimientos.salida');
        //dd($interes);
        $entrada = DB::table('movimientos')
                   ->where('movimientos.tipMvto','=','A')
                   ->where('movimientos.fecMvto',$request->fecha)
                   ->sum('movimientos.entrada');

        $positivo = DB::table('movimientos')
                  ->where('movimientos.fecMvto',$request->fecha)
                  ->where('movimientos.salida','>','0')
                  ->sum('movimientos.salida');
        
        $negativo = DB::table('movimientos')
                  ->where('movimientos.fecMvto',$request->fecha)
                  ->where('movimientos.salida','<','0')
                  ->sum('movimientos.salida');

        $salida = abs($negativo) + $positivo;

        $entrada = $entrada - $salida;

        return view('movimiento.index')->with('movimiento',$movimiento)->with('interes',$interes)->with('entrada',$entrada)->with('salida',$salida); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
