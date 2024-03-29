<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Cuentas;
use App\Models\Movimiento;

class CuentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $movimiento = DB::table('movimientos')
        
        ->join('tarjetas','tarjetas.idTarjeta', '=','movimientos.idTarjeta')
        ->join('clientes','clientes.idCliente', '=','tarjetas.idCliente')
                      ->select('tipMvto','salida','movimientos.idTarjeta','idMovimiento','tarjetas.valorPrestado as valorPrestado','tarjetas.valorTotal as valorTotal',
                      'clientes.nombre')
                      //->where('movimientos.fecMvto','=',now()/*$request->fecha*/)
                      ->where('movimientos.mcaAjuste','=','1')
                      ->orderBy('idTarjeta','desc')
                      ->paginate(100);

         //dd($movimiento);
        return view('cuenta.index')->with('movimiento',$movimiento); 
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
        $movimiento = Movimiento::findOrFail($id);
        return view('cuenta.edit')->with('movimiento',$movimiento);
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
        $movimiento=Movimiento::findOrFail($id);
        $movimiento->salida =$request->valor;
        $movimiento->mcaAjuste =0;
        $movimiento->save();

        return redirect()->route('cuenta.index');
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
