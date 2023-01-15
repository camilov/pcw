@extends('adminlte::page')


@section('title', 'Consultas')


@section('content')

    <hr>
	<table class="table table-sm table-condensed table-striped table-bordered col-md-6" id="exTable">
        <thead class="tableThead thead-dark">
            <th scope="col">Nombre</th>
            <th scope="col">Prestamo</th>
            <th scope="col">Pagado</th>
        </thead>
        <tbody>
            @foreach($deudores as $deudor)
                <tr>
                    <td>{{$deudor->nombre}}</td>
                    <td>{{$deudor->prestamo}}</td>
                    <td>{{$deudor->pagado}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
            {!! $deudores->links() !!}





@endsection