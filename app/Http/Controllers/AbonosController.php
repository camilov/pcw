<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Abono;
use App\Models\Tarjeta;
use App\Models\Cuentas;


class AbonosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $abono = DB::table('abonos')
                      ->select('idAbono','idTarjeta','numCuota','valorAbono','fechaAbono')
                      ->where('abonos.idTarjeta','=',$id)
                      ->orderBy('idAbono','ASC')
                      ->get();

        $cliente = DB::table('tarjetas')
                      ->select('idCliente')
                      ->where('tarjetas.idTarjeta','=',$id)
                      ->get();

        foreach($cliente as $clientes)
        {
           $idCliente = $clientes->idCliente;
        }

        return view('abono.index')->with('abono',$abono)->with('id',$id)->
        with('idCliente',$idCliente);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        
        $valorDefecto = DB::table('tarjetas')
                           ->select('valorDefecto')
                           ->where('tarjetas.idTarjeta','=',$id)
                           ->get();
        return view('abono.create')->with('id',$id)->with('valorDefecto',$valorDefecto);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $abono = new Abono($request->all());

        $idTarjeta = $request->input('idTarjeta');
        $numCuota = $request->input('numCuota');
        $valorAbono = $request->input('valorAbono');
        $valorAbono2 = $request->input('valorAbono');
        $valores = DB::table('tarjetas')
                      ->select('numCuotas','valorTotal')
                      ->where('tarjetas.idTarjeta','=',$idTarjeta)
                      ->get();
        
        foreach($valores as $valor)
        {
           $numCuota = $numCuota +$valor->numCuotas;
           $valorAbono = $valorAbono + $valor->valorTotal;
        }

        $tarjeta=Tarjeta::findOrFail($idTarjeta);
        $tarjeta->numCuotas =$numCuota;
        $tarjeta->valorTotal =$valorAbono;

        /*$valores2 = DB::table('totales')
                      ->select('totalCapital','totalPagado')
                      ->where('totales.idTotal','=',1)
                      ->get();
        
        foreach($valores2 as $valor2)
        {
           $capital     = $valor2->totalCapital + $valorAbono2;
           $totalPagado = $valor2->totalPagado  + $valorAbono2;
        }

        $total=Cuentas::findOrFail(1);
        $total->totalCapital = $capital;
        $total->totalPagado  = $totalPagado;*/


        $tarjeta->save();
        $abono->save();
       // $total->save();

        return redirect()->route('abono.index',$request->idTarjeta);
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
    public function destroy($id,$idTarjeta)
    {
        $abono = Abono::findOrFail($id);
        $abono->delete();
        return redirect()->route('abono.index',$idTarjeta);
    }
}
