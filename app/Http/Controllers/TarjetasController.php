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
        $total->totalCapital  = $capital;
        $total->totalPrestado = $totalPrestado;
        $total->save();

        $tarjeta->fechaPrestamo = now();
        $tarjeta->fecActu       = now();
        $tarjeta->idEstado      = 1;
        $tarjeta->valorTotal    = 0;
        $tarjeta->numCuotas     = 0;
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
        $movimiento->mcaAjuste = 0;
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
        $estado = $request->idEstado;
        $nuevoValor = $request->nuevoValor;

        
        $tarjetas = DB::table('tarjetas')
                      ->select('valorPrestado','valorTotal','idEstado')
                      ->where('tarjetas.idTarjeta','=',$id)
                      ->get();

        foreach($tarjetas as $tarjeta3)
        {
           $valorPrestado = $tarjeta3->valorPrestado;
           $valorTotal    = $tarjeta3->valorTotal;
           $idEstado      = $tarjeta3->idEstado;
        }

        //dd($valorTotal);

        if($idEstado == 1)
        {
            if($estado == 2)
            {
                if($renovar =="s")
                {
                    $tarjeta3 = new Tarjeta();
                    $tarjeta3->idCliente     = $request->idCliente;
                    
                    if($nuevoValor > 0)
                    {
                        $tarjeta3->valorPrestado = $nuevoValor;  
                    }else
                    {
                        $tarjeta3->valorPrestado = $valorPrestado; 
                    }
                    
                    $tarjeta3->valorTotal    = 0;
                    $tarjeta3->fechaPrestamo = now();
                    $tarjeta3->numCuotas     = 0;
                    $tarjeta3->idEstado      = 1;
                    $tarjeta3->interes       = 0;
                    $tarjeta3->valorDefecto  = $request->valorDefecto;
                    $tarjeta3->fecActu       = now();
                    $tarjeta3->save();

                    self::calculaValores($nuevoValor,$valorPrestado,$valorTotal,$renovar,$id,$request->idCliente);   
                }else
                {
                    self::calculaValores($nuevoValor,$valorPrestado,$valorTotal,$renovar,$id,$request->idCliente);
                }
                
                $tarjeta->fecActu   = now();
                $tarjeta->save();

            }else
            {
                //mensaje que ya esta cerrada la tarjeta
            }
        }else
        {
            //mensaje que ya esta cerrada la tarjeta
        }
        
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

        $movimientos = DB::table('movimientos')
                      ->select('idMovimiento')
                      ->where('movimientos.idTarjeta','=',$id)
                      ->get();
        //dd($movimientos);
        foreach($tarjetas as $tarjeta3)
        {
           $valorPrestado = $tarjeta3->valorPrestado;
           $valorTotal    = $tarjeta3->valorTotal;
        }

        $nuevoValorCapital = $capital - ($valorPrestado - $valorTotal);


        $total=Cuentas::findOrFail(3);
        $total->totalCapital = $nuevoValorCapital;
        $total->save();

        /*$movimiento = new Movimiento();
        $movimiento->entrada   = $valorPrestado;  
        $movimiento->salida    = 0; 
        $movimiento->tipMvto   = 'BT';
        $movimiento->idTarjeta = $id;
        $movimiento->idCliente = $idCliente;
        $movimiento->mcaAjuste = 0;
        $movimiento->fecMvto   = now();
        $movimiento->save();*/

        $tarjeta->delete();
        return redirect()->route('tarjeta.index',$idCliente);
    }

    public function calculaValores($nuevoValor,$valorPrestado,$valorTotal,$renueva,$idTarjeta,$idCliente)
    {
        $nuevoTotalPrestado;
        $nuevoTotalPagado;
        $nuevoTotalCapital;
        $interes;
        $operar;
        $valorTotalM;
        $valorTotalFinal;
        $interes = $valorPrestado*0.3;
        $valorTotalM = $valorPrestado + $interes;

        //movimiento2 de pago de interes
        $movimiento2 = new Movimiento();
        $movimiento2->entrada   = 0;  
        $movimiento2->tipMvto   = 'PI';
        $movimiento2->idTarjeta = $idTarjeta;
        $movimiento2->idCliente = $idCliente;
        $movimiento2->fecMvto   = now();

        if($renueva =="n")
        {
            if($valorTotal ==  $valorTotalM)
            {
                $movimiento2->salida = $interes/2;
                $movimiento2->mcaAjuste = 0;
            }
            else
            {
                if(($valorTotal >=$valorPrestado && $valorTotal <= $valorTotalM) || $valorTotal < $valorPrestado){
                    $movimiento2->salida = $interes/2;
                    $movimiento2->mcaAjuste = 1;

                    
                }else{
                    $movimiento2->salida = ($valorTotal-$valorPrestado)/2;
                    $movimiento2->mcaAjuste = 1;
                }
            }

            //dd($valorTotal);
            $movimiento2->save();

        }else{
            //Movimiento de prestamo
            $movimiento = new Movimiento();
            $movimiento->entrada   = 0;  
            $movimiento->tipMvto   = 'RE';
            $movimiento->idTarjeta = $idTarjeta;
            $movimiento->idCliente = $idCliente;
            $movimiento->fecMvto   = now();

            //-------------------

            if($valorTotal ==  $valorTotalM)
            {
                $movimiento2->salida = $interes/2;
                $movimiento2->mcaAjuste = 0;

                if($nuevoValor > 0)
                {
                    $movimiento->salida = abs($valorTotalM - $valorTotal - $nuevoValor);
                    $movimiento->mcaAjuste = 1;
                }else{

                    $movimiento->salida = $valorPrestado;
                    $movimiento->mcaAjuste = 0;
                }
            }
            else
            {
                if($nuevoValor > 0)
                {
                    $movimiento->salida = abs($valorTotalM - $valorTotal - $nuevoValor);
                    $movimiento->mcaAjuste = 1;
                }else{
                    
                    if($valorTotal > $valorTotalM)
                    {
                        $movimiento->salida = $valorPrestado;
                        $movimiento->mcaAjuste = 0;
                    }else{
                        $movimiento->salida = abs($valorTotalM - $valorTotal - $valorPrestado);
                        $movimiento->mcaAjuste = 1;
                    }
                    
                }    
            
                if(($valorTotal >=$valorPrestado && $valorTotal <= $valorTotalM) || $valorTotal < $valorPrestado){
                    $movimiento2->salida = $interes/2;
                    $movimiento2->mcaAjuste = 1;
                }else{
                    $movimiento2->salida = ($valorTotal-$valorPrestado)/2;
                    $movimiento2->mcaAjuste = 1;
                }
            }
            $movimiento->save();
            $movimiento2->save();
        }
    }
    
}
