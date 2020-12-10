@extends('adminlte::page')


@section('title', 'Lista de totales')


@section('content')

    <hr>
	<table class="table table-sm table-condensed table-striped table-bordered col-md-6" id="exTable">
        <thead class="tableThead thead-dark">
            <th scope="col">Capital</th>
            <th scope="col">Interes</th>
            <th scope="col">Ganancia C</th>
            <th scope="col">Ganancia W</th>
            <th scope="col">Total Prestado</th>
            <th scope="col">Total Pagado</th>
        </thead>
        <tbody>
            @foreach($cuenta as $cuentas)
                <tr>
                    <td>{{$cuentas->totalCapital}}</td>
                    <td>{{$cuentas->totalInteres}}</td>
                    <td>{{$cuentas->gananciaC}}</td>
                    <td>{{$cuentas->gananciaW}}</td>
                    <td>{{$cuentas->totalPrestado}}</td>
                    <td>{{$cuentas->totalPagado}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
            {!! $cuenta->links() !!}




@endsection