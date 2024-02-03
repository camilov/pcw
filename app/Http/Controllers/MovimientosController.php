<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\Tarjeta;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


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
                      ->paginate(100);

        $interes = DB::table('movimientos')
                   ->where('movimientos.tipMvto','=','PI')
                   ->where('movimientos.fecMvto',$request->fecha)
                   ->sum('movimientos.salida');

        $prestamos = DB::table('movimientos')
                   ->where('movimientos.tipMvto','=','PR')
                   ->where('movimientos.fecMvto',$request->fecha)
                   ->sum('movimientos.salida');

        $renovaciones = DB::table('movimientos')
                   ->where('movimientos.tipMvto','=','RE')
                   ->where('movimientos.fecMvto',$request->fecha)
                   ->sum('movimientos.salida');

        $pr = $prestamos + $renovaciones;
        //dd($interes);
        $entrada = DB::table('movimientos')
                   ->where('movimientos.tipMvto','=','A')
                   ->where('movimientos.fecMvto',$request->fecha)
                   ->sum('movimientos.entrada');
                  // dd($entrada);
        $positivo = DB::table('movimientos')
                  ->where('movimientos.fecMvto',$request->fecha)
                  ->where('movimientos.salida','>','0')
                  ->sum('movimientos.salida');
        
        $negativo = DB::table('movimientos')
                  ->where('movimientos.fecMvto',$request->fecha)
                  ->where('movimientos.salida','<','0')
                  ->sum('movimientos.salida');

        $anulacionAbono  = DB::table('movimientos')
                        ->where('movimientos.tipMvto','=','AA')
                        ->where('movimientos.fecMvto',$request->fecha)
                        ->sum('movimientos.salida');        

        $salida = abs($negativo) + $positivo;
        $total = $entrada - $anulacionAbono;

        $entrada = $entrada - $salida;
        session(['movimiento_data' => [
            'movimiento' => $movimiento,
            'interes' => $interes,
            'entrada' => $entrada,
            'salida' => $salida,
            'total' => $total,
            'pr' => $pr,
            'fecha' => $request->fecha,
        ]]);


        return view('movimiento.index')->with('movimiento',$movimiento)->with('interes',$interes)->with('entrada',$entrada)->with('salida',$salida)->with('total',$total)
              ->with('pr',$pr); 
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

    public function generatePDF()
    {
        // Retrieve the data from the session
        $sessionData = session('movimiento_data');
       // dd($sessionData);

        $data = [
            'title'      => 'Cuadre',
            'movimiento' => $sessionData['movimiento'],
            'interes' => $sessionData['interes'],
            'entrada' => $sessionData['entrada'],
            'salida' => $sessionData['salida'],
            'total' => $sessionData['total'],
            'pr' => $sessionData['pr'],
        ];
        //dd($data);
    
        $pdf = PDF::loadView('movimiento.sample', $data);
    
        return $pdf->download('cuadre-'.$sessionData['fecha'].'.pdf');
    }

    public function generatePdfMorosidad()
    {
        $result = Tarjeta::join('clientes as b', 'tarjetas.idCliente', '=', 'b.idCliente')
                            ->select('tarjetas.idCliente', 'b.nombre', 'tarjetas.valorPrestado', 'tarjetas.valorTotal', 'tarjetas.numCuotas')
                            ->where('tarjetas.idEstado', 1)
                            ->whereNotIn('tarjetas.idCliente', [22])
                            ->get();
        $data = [
            'title'      => 'Morosidad',
            'result'      =>  $result,
        ];
        
        $pdf = PDF::loadView('movimiento.morosidad',$data);
    
        return $pdf->download('Morosidad.pdf');
    }
}
