@extends('adminlte::page')


@section('title', 'Movimientos')


@section('content')

	<table class="table table-sm table-condensed table-striped table-bordered" id="exTable">
        <thead class="tableThead thead-dark ">
            <th scope="col">Entrada</th>
            <th scope="col">Salida</th>
            <th scope="col">Tipo Mvto</th>
            <th scope="col">Tarjeta</th>
            <th scope="col">Cliente</th>
            <th scope="col">Fecha Mvto</th>
        </thead>
        <tbody>
            @foreach($movimiento as $movimientos)
                <tr>
                    <td>{{$movimientos->entrada}}</td>
                    <td>{{$movimientos->salida}}</td>
                    <td>{{$movimientos->tipMvto}}</td>
                    <td>{{$movimientos->idTarjeta}}</td>
                    <td>{{$movimientos->idCliente}}</td>
                    <td>{{$movimientos->fecMvto}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection