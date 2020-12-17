<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Tarjeta;
use App\Models\Estado;
use App\Models\Cuentas;




class TarjetasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index($id)
    {
        $tarjeta = DB::table('tarjetas')
                      ->join('estados','estados.idEstado', '=','tarjetas.idEstado')
                      ->select('estados.descripcion as descripcion','valorPrestado','valorTotal','fechaPrestamo','numCuotas','interes','idTarjeta')
                      ->where('tarjetas.idCliente','=',$id)
                      ->orderBy('idTarjeta','desc')
                      ->get();

        $cliente = DB::table('clientes')
                      ->select('nombre')
                      ->where('clientes.idCliente','=',$id)
                      ->get();
        

        return view('tarjeta.index')->with('tarjeta',$tarjeta)->with('id',$id)->with('cliente',$cliente);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $estado = Estado::all();
        return view('tarjeta.create')->with('id',$id)->with('estado',$estado);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tarjeta = new Tarjeta($request->all());
        $valorPrestado = $request->input('valorPrestado');
        /*$valores = DB::table('totales')
                      ->select('totalCapital','totalPrestado')
                      ->where('totales.idTotal','=',1)
                      ->get();
        
        foreach($valores as $valor)
        {
           $capital       = $valor->totalCapital - $valorPrestado;
           $totalPrestado = $valor->totalPrestado + $valorPrestado;
        }

        $total=Cuentas::findOrFail(1);
        $total->totalCapital =$capital;
        $total->totalPrestado =$totalPrestado;
        $total->save();*/

        $tarjeta->save();
        return redirect()->route('tarjeta.index',$request->idCliente);
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
    public function edit($id,$idCliente)
    {
        $tarjeta = Tarjeta::findOrFail($id);
        $estado = Estado::all();
        return view('tarjeta.edit')->with('tarjeta',$tarjeta)->with('estado',$estado)->with('idCliente',$idCliente);
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
        $tarjeta=Tarjeta::findOrFail($id);
        $tarjeta->idEstado =$request->idEstado;
        $tarjeta->valorDefecto =$request->valorDefecto;

       // dd($request->voltear);

        /*$estado = $request->valorDefecto;

        $tarjetas = DB::table('tarjetas')
                      ->select('valorPrestado','valorTotal')
                      ->where('tarjetas.idTarjeta','=',$id)
                      ->get();

        foreach($tarjetas as $tarjeta)
        {
           $valorPrestado = $valor->valorPrestado;
           $valorTotal    = $valor->valorTotal;
        }


        if($estado == 2){

            if($valorTotal > $valorPrestado){
                    
            }

        }*/

        $tarjeta->save();
        return redirect()->route('tarjeta.index',$request->idCliente);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$idCliente)
    {
        $tarjeta = Tarjeta::findOrFail($id);
        $tarjeta->delete();
        return redirect()->route('tarjeta.index',$idCliente);
    }
}
