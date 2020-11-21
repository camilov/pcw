<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Tarjeta;
use App\Models\Estado;




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

        return view('tarjeta.index')->with('tarjeta',$tarjeta)->with('id',$id);
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
    public function edit($id,$idTarjeta)
    {
        $tarjeta = Tarjeta::findOrFail($id);
        return view('tarjeta.edit')->with('tarjeta',$tarjeta)->with('idTarjeta',$idTarjeta);
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
        $tarjeta=Cliente::findOrFail($id);
        $tarjeta->nombre =$request->nombre;
        $tarjeta->save();
        return redirect()->route('tarjeta.index');
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
