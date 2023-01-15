@extends('adminlte::page')


@section('title', 'Lista de ajustes')


@section('content')

    <hr>
	<table class="table table-sm table-condensed table-striped table-bordered col-md-6" id="exTable">
        <thead class="tableThead thead-dark">
            <th scope="col">Cliente</th>
            <th scope="col">Valor prestado</th>
            <th scope="col">Valor Total</th>
            <th scope="col">Tarjeta</th>
            <th scope="col">Valor</th>
            <th scope="col">Movimiento</th>
            <th scope="col">Acciones</th>
        </thead>
        <tbody>
            @foreach($movimiento as $movimientos)
                <tr>
                    <td>{{$movimientos->nombre}}</td>
                    <td>{{$movimientos->valorPrestado}}</td>
                    <td>{{$movimientos->valorTotal}}</td>
                    <td>{{$movimientos->idTarjeta}}</td>
                    <td>{{$movimientos->salida}}</td>
                    <td>{{$movimientos->tipMvto}}</td>
                    <td>
                    <a href="{{route('cuenta.edit',[$movimientos->idMovimiento])}}" class="fa fa-wrench"></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
            <!--{!! $movimiento->links() !!}-->




@endsection