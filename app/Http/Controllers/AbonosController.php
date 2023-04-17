<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Abono;
use App\Models\Tarjeta;
use App\Models\Cuentas;
use App\Models\Movimiento;



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
                           ->first();
                           
        $valorAbono = DB::table('abonos')
                            ->select('valorAbono')
                            ->where('abonos.idTarjeta','=',$id)
                            ->latest('idAbono')
                            ->first();
                                                                
        $valorFinal = 0;
       // dd($valorDefecto);
        
        if(empty($valorAbono)){
            if($valorDefecto != '0'){
                $valorFinal = $valorDefecto->valorDefecto;
            }else{
                $valorFinal = 0;
                //dd($valorFinal);
            }
            
        }else{
            /*if($valorDefecto == '0'){
                $valorFinal = $valorAbono;
            }else{
                if($valorDefecto != $valorAbono){
                    $valorFinal = $valorAbono;
                }else{
                    $valorFinal = $valorDefecto;
                }
            }*/
            $valorFinal = $valorAbono->valorAbono;
            
        }


        /*if(is_object($valorAbono)){
            $valorFinal = $valorAbono->valorAbono;
        } else {
            $valorFinal = 0;
        }*/
        //$valorFinal = json_encode($valorFinal);
       // dd($valorFinal); 
        //return view('abono.create')->with('id',$id)->with('valorFinal',$valorFinal);
        return view('abono.create', compact('id', 'valorFinal'))/*->with('valorFinal', strval($valorFinal))*/;
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
                      ->select('numCuotas','valorTotal','idCliente')
                      ->where('tarjetas.idTarjeta','=',$idTarjeta)
                      ->get();
        
        foreach($valores as $valor)
        {
           $numCuota = $numCuota +$valor->numCuotas;
           $valorAbono = $valorAbono + $valor->valorTotal;
           $idCliente = $valor->idCliente;
        }

        $tarjeta=Tarjeta::findOrFail($idTarjeta);
        $tarjeta->numCuotas =$numCuota;
        $tarjeta->valorTotal =$valorAbono;

        $valores2 = DB::table('totales')
                      ->select('totalCapital','totalPagado')
                      ->where('totales.idTotal','=',3)
                      ->get();
        
        foreach($valores2 as $valor2)
        {
           $capital     = $valor2->totalCapital + $valorAbono2;
           $totalPagado = $valor2->totalPagado  + $valorAbono2;

        }

        
        $total=Cuentas::findOrFail(3);
        $total->totalCapital = $capital;
        $total->totalPagado  = $totalPagado;


        $movimiento = new Movimiento();
        $movimiento->entrada   = $valorAbono2;  
        $movimiento->salida    = 0; 
        $movimiento->tipMvto   = 'A';
        $movimiento->idTarjeta = $idTarjeta;
        $movimiento->idCliente = $idCliente;
        $movimiento->mcaAjuste = 0;
        $movimiento->fecMvto   = now();

        
        $abono->fechaAbono   = now();

        $tarjeta->save();
        $abono->save();
        $total->save();
        $movimiento->save();

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
       
        $tarjeta=Tarjeta::findOrFail($idTarjeta);
        $tarjeta->numCuotas = $tarjeta->numCuotas-1;
        $tarjeta->valorTotal = $tarjeta->valorTotal - $abono->valorAbono;

        $valores2 = DB::table('totales')
                      ->select('totalCapital','totalPagado')
                      ->where('totales.idTotal','=',3)
                      ->get();
        
        foreach($valores2 as $valor2)
        {
           $capital     = $valor2->totalCapital - $abono->valorAbono;
           $totalPagado = $valor2->totalPagado  - $abono->valorAbono;

        }


        $clientes = DB::table('tarjetas')
                      ->select('idCliente')
                      ->where('tarjetas.idTarjeta','=',$idTarjeta)
                      ->get();
        
        foreach($clientes as $cliente)
        {
            $idCliente = $cliente->idCliente;
        }

        $movimiento = new Movimiento();
        $movimiento->entrada   = 0; 
        $movimiento->salida    = $abono->valorAbono;  
        $movimiento->tipMvto   = 'AA';
        $movimiento->idTarjeta = $idTarjeta;
        $movimiento->idCliente = $idCliente;
        $movimiento->mcaAjuste = 0;
        $movimiento->fecMvto   = now();

        $total=Cuentas::findOrFail(3);
        $total->totalCapital = $capital;
        $total->totalPagado  = $totalPagado;

        $tarjeta->save();
        $abono->delete();
        $total->save();
        $movimiento->save();

        return redirect()->route('abono.index',$idTarjeta);
    }
}
