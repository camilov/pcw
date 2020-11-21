@extends('adminlte::page')


@section('title', 'Lista de abonos')


@section('content')

    <div class="form-row" >   
        <div class="form-group col-md-4">                   
	       <a href="{{route('abono.create',$id)}}" class="btn btn-info glyphicon glyphicon-plus">Registrar</a> 
        
           <a href="{{route('tarjeta.index',$idCliente)}}" class="btn btn-info glyphicon glyphicon-plus">Tarjetas</a>
        </div>
    </div>
    <br>
	<table class="table table-sm table-condensed table-striped table-bordered" id="exTable">
        <thead class="tableThead thead-dark ">
            <th scope="col">Valor Abono</th>
            <th scope="col">N° Cuota</th>
            <th scope="col">Fecha Abono</th>
            <th scope="col">Acciones</th>
        </thead>
        <tbody>
            @foreach($abono as $abonos)
                <tr>
                    <td>{{$abonos->valorAbono}}</td>
                    <td>{{$abonos->numCuota}}</td>
                    <td>{{$abonos->fechaAbono}}</td>
                    <td>
                    <!--<a href="{{route('abono.edit',[$abonos->idTarjeta,$id])}}" class="fa fa-wrench"></a>-->
                    <a href="{{route('abono.destroy',[$abonos->idAbono,$id])}}" onclick="return confirm('¿Seguro que deseas eliminar el abono?')" class="fa fa-trash"></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection