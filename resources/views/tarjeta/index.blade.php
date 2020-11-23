@extends('adminlte::page')


@section('title', 'Lista de tarjetas')


@section('content')

                           
	<a href="{{route('tarjeta.create',$id)}}" class="btn btn-info glyphicon glyphicon-plus">Nueva Tarjeta</a><hr>
    <br>
	<table class="table table-sm table-condensed table-striped table-bordered" id="exTable">
        <thead class="tableThead thead-dark ">
            <th scope="col">Valor Prestado</th>
            <th scope="col">Valor Total</th>
            <th scope="col">Fecha Prestamo</th>
            <th scope="col">Numero de cuotas</th>
            <th scope="col">Estado</th>
            <th scope="col">Interes</th>
            <th scope="col">Acciones</th>
        </thead>
        <tbody>
            @foreach($tarjeta as $tarjetas)
                <tr>
                    <td>{{$tarjetas->valorPrestado}}</td>
                    <td>{{$tarjetas->valorTotal}}</td>
                    <td>{{$tarjetas->fechaPrestamo}}</td>
                    <td>{{$tarjetas->numCuotas}}</td>
                    <td>{{$tarjetas->descripcion}}</td>
                    <td>{{$tarjetas->interes}}</td>
                    <td>
                    <a href="{{route('tarjeta.edit',[$tarjetas->idTarjeta,$id])}}" class="fa fa-wrench"></a>
                    <a href="{{route('tarjeta.destroy',[$tarjetas->idTarjeta,$id])}}" onclick="return confirm('¿Seguro que deseas eliminar tarjeta?')" class="fa fa-trash"></a>
                    <a href="{{route('abono.index',$tarjetas->idTarjeta)}}" class="fa fa-plus"></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection