<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Tarjeta;
use App\Models\Estado;
use App\Models\Cuentas;
use App\Models\Movimiento;
use App\Models\Porcentaje;




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
        $porcentaje = Porcentaje::all();
        return view('tarjeta.create')->with('id',$id)->with('estado',$estado)->with('porcentaje',$porcentaje);
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
        $interes =$request->input('idInteres') ;
        //dd(0.1);
        $valores = DB::table('totales')
                      ->select('totalCapital','totalPrestado')
                      ->where('totales.idTotal','=',3)
                      ->get();
        
        foreach($valores as $valor)
        {
           $capital       = $valor->totalCapital - $valorPrestado;
           $totalPrestado = $valor->totalPrestado + $valorPrestado;
        }

        $total=Cuentas::findOrFail(3);
        $total->totalCapital =$capital;
        $total->totalPrestado =$totalPrestado;
        $total->save();

        $tarjeta->save();

        $tarjetas = DB::table('tarjetas')
                      ->where('tarjetas.idCliente','=',$request->idCliente)
                      ->max('idTarjeta');
                      
        $movimiento = new Movimiento();
        $movimiento->entrada   = 0;
        $movimiento->salida    = $valorPrestado;   
        $movimiento->tipMvto   = 'PR';
        $movimiento->idTarjeta = $tarjetas;
        $movimiento->idCliente = $request->idCliente;
        $movimiento->fecMvto   = now();
        $movimiento->save();

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

        $renovar = $request->renovar;
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
        }

        
        
        if($estado == 2){
            if($voltear =="s"){
                if($especial =="s"){
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

                    self::calculaValores($nuevoValor,$valorTotal,$voltear,$renovar,$especial,$id,$request->idCliente);
                }else
                {   
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

                    self::calculaValores($valorPrestado,$valorTotal,$voltear,$renovar,$especial,$id,$request->idCliente);
                }
            }else{
                if($renovar =="s"){
                    if($especial =="s"){
                        $tarjeta4 = new Tarjeta();
                        $tarjeta4->idCliente     = $request->idCliente;
                        $tarjeta4->valorPrestado = $nuevoValor;  
                        $tarjeta4->valorTotal    = 0;
                        $tarjeta4->fechaPrestamo = now();
                        $tarjeta4->numCuotas     = 0;
                        $tarjeta4->idEstado      = 1;
                        $tarjeta4->interes       = 0;
                        $tarjeta4->valorDefecto  = $nuevoValorDefecto;
                        $tarjeta4->save();

                        self::calculaValores($nuevoValor,$valorTotal,$voltear,$renovar,$especial,$id,$request->idCliente);
                    }else
                    {
                        $tarjeta3 = new Tarjeta();
                        $tarjeta3->idCliente     = $request->idCliente;
                        $tarjeta3->valorPrestado = $valorPrestado;  
                        $tarjeta3->valorTotal    = 0;
                        $tarjeta3->fechaPrestamo = now();
                        $tarjeta3->numCuotas     = 0;
                        $tarjeta3->idEstado      = 1;
                        $tarjeta3->interes       = 0;
                        $tarjeta3->valorDefecto  = $request->valorDefecto;
                        $tarjeta3->save();

                        self::calculaValores($valorPrestado,$valorTotal,$voltear,$renovar,$especial,$id,$request->idCliente);
                    }
                }
            }
            if($renovar =="n" && $voltear == "n")
            {
                self::calculaValores($valorPrestado,$valorTotal,$voltear,$renovar,$especial,$id,$request->idCliente);
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

        $valores2 = DB::table('totales')
                      ->select('totalCapital','totalPagado','totalPrestado')
                      ->where('totales.idTotal','=',3)
                      ->get();
        
        foreach($valores2 as $valor2)
        {
           $capital       = $valor2->totalCapital ;
           $totalPagado   = $valor2->totalPagado  ;
           $totalPrestado = $valor2->totalPrestado;

        }


        $tarjetas = DB::table('tarjetas')
                      ->select('valorPrestado','valorTotal')
                      ->where('tarjetas.idTarjeta','=',$id)
                      ->get();



        foreach($tarjetas as $tarjeta3)
        {
           $valorPrestado = $tarjeta3->valorPrestado;
           $valorTotal    = $tarjeta3->valorTotal;
        }

        $nuevoValorCapital = $capital - ($valorPrestado - $valorTotal);


        $total=Cuentas::findOrFail(3);
        $total->totalCapital = $nuevoValorCapital;
        $total->save();

        $movimiento = new Movimiento();
        $movimiento->entrada   = 0;  
        $movimiento->salida    = $valorPrestado - $valorTotal; 
        $movimiento->tipMvto   = 'BT';
        $movimiento->idTarjeta = $id;
        $movimiento->idCliente = $idCliente;
        $movimiento->fecMvto   = now();
        $movimiento->save();

        $tarjeta->delete();
        return redirect()->route('tarjeta.index',$idCliente);
    }

    public function calculaValores($valorPrestado,$valorTotal,$voltea,$renueva,$especial,$idTarjeta,$idCliente)
    {
        $valores2 = DB::table('totales')
                      ->select('totalCapital','totalPagado','totalPrestado')
                      ->where('totales.idTotal','=',3)
                      ->get();
        
        foreach($valores2 as $valor2)
        {
           $capital       = $valor2->totalCapital ;
           $totalPagado   = $valor2->totalPagado  ;
           $totalPrestado = $valor2->totalPrestado;

        }

        if($voltea =="s" || $renueva =="s")
        {
            $movimiento = new Movimiento();
            $movimiento->entrada   = 0;  
            $movimiento->tipMvto   = 'PR';
            $movimiento->idTarjeta = $idTarjeta;
            $movimiento->idCliente = $idCliente;
            $movimiento->fecMvto   = now();
        }

        $movimiento2 = new Movimiento();
        $movimiento2->entrada   = 0;  
        $movimiento2->tipMvto   = 'PI';
        $movimiento2->idTarjeta = $idTarjeta;
        $movimiento2->idCliente = $idCliente;
        $movimiento2->fecMvto   = now();

        
        $nuevoTotalPrestado;
        $nuevoTotalPagado;
        $nuevoTotalCapital;

        if($voltea =="s"){
            $nuevoTotalPrestado = $totalPrestado + $valorPrestado;
            $nuevoTotalCapital  = $capital - ($valorPrestado + ($valorPrestado*0.3)-$valorTotal-(($valorPrestado*0.3)/2));  
            $movimiento->salida = $valorPrestado + ($valorPrestado*0.3)-$valorTotal-$valorPrestado;
            $movimiento2->salida = ($valorPrestado*0.3)/2;
        }else{
            if($renueva =="s"){
                $nuevoTotalPrestado = $totalPrestado + $valorPrestado;
                $nuevoTotalCapital  = $capital - ($valorPrestado - (($valorPrestado*0.3)/2));
                $movimiento->salida = $valorPrestado;
                $movimiento2->salida = ($valorPrestado*0.3)/2;
            }elseif ($voltea =="n" && $renueva =="n") {
                $nuevoTotalPrestado = $totalPrestado;
                $nuevoTotalCapital  = $capital - (($valorPrestado*0.3)/2);
                $movimiento2->salida = ($valorPrestado*0.3)/2;
            }
        }


        $total=Cuentas::findOrFail(3);
        $total->totalCapital   = $nuevoTotalCapital;
        $total->totalPrestado  = $nuevoTotalPrestado;
        $total->save();


        if($voltea =="s" || $renueva =="s")
        {
          $movimiento->save();
        }
        
        $movimiento2->save();


    }
    
}
