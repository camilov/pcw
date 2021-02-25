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


        $especial = $request->especial;
        $voltear = $request->voltear;
        $estado = $request->idEstado;
        $nuevoValor = $request->nuevoValor;
        $nuevoValorDefecto = $request->nuevoValorDefecto;

        
        $tarjetas = DB::table('tarjetas')
                      ->select('valorPrestado','valorTotal')
                      ->where('tarjetas.idTarjeta','=',$id)
                      ->get();



        foreach($tarjetas as $tarjeta3)
        {
           $valorPrestado = $tarjeta3->valorPrestado;
           $valorTotal    = $tarjeta3->valorTotal;
          // dd($valorPrestado);
        }

        

        if($estado == 2){
            
            if($voltear ="s"){
                if($especial ="s"){
                    $tarjeta1 = new Tarjeta();
                    $tarjeta1->idCliente     = $request->idCliente;
                    $tarjeta1->valorPrestado = $valorPrestado;  
                    $tarjeta1->valorTotal    = 0;
                    $tarjeta1->fechaPrestamo = now();
                    $tarjeta1->numCuotas     = 0;
                    $tarjeta1->idEstado      = 1;
                    $tarjeta1->interes       = 0;
                    $tarjeta1->valorDefecto  = $request->valorDefecto;
                    $tarjeta1->save();
                }else
                {
                   // dd($valorPrestado);
                    $tarjeta2 = new Tarjeta();
                    $tarjeta2->idCliente     = $request->idCliente;
                    $tarjeta2->valorPrestado = $nuevoValor;  
                    $tarjeta2->valorTotal    = 0;
                    $tarjeta2->fechaPrestamo = now();
                    $tarjeta2->numCuotas     = 0;
                    $tarjeta2->idEstado      = 1;
                    $tarjeta2->interes       = 0;
                    $tarjeta2->valorDefecto  = $nuevoValorDefecto;
                    $tarjeta2->save();
                }
            }

        }

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
