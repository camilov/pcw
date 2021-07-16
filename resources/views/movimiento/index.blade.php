@extends('adminlte::page')


@section('title', 'Movimientos')


@section('content')

    <div class="form-row" >   
        <form action="{{route('movimientos.index')}}" method="GET" class="form-group form-center">

              @csrf
              <div class="form-group col-md-12">
                
                <label for="fecha">Buscar</label>
                <input type="date" id="fecha" name="fecha" class="form-control"
                placeholder="AAAA-MM-DD"/>
                <span class="input-group-btn"><button type="submit" class="btn btn-primary">Buscar</button></span>
              </div>
        </form>
    </div>
    <br>
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
                    <td>{{$movimientos->nomMvto}}</td>
                    <td>{{$movimientos->idTarjeta}}</td>
                    <td>{{$movimientos->nombre}}</td>
                    <td>{{$movimientos->fecMvto}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection