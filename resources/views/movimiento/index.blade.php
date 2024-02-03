@extends('adminlte::page')


@section('title', 'Movimientos')


@section('content')

    <form action="{{route('movimientos.index')}}" method="GET" class="form-group form-center">
        @csrf
        <div class="form-row" >  
            <div class="form-group col-md-0"> 
                <label for="fecha">Fecha</label>
            </div>
            <div class="form-group col-md-2">    
                <input type="date" id="fecha" name="fecha" class="form-control"
                placeholder="AAAA-MM-DD"/>
            </div>
            <div class="form-group col-md-4">
              <span class="input-group-btn"><button type="submit" class="btn btn-primary">Buscar</button></span>
            </div>
        </div>
        <div class="form-row" >  
        <div class="form-group col-md-0"> 
            <a href="{{ route('movimientos.generatePDF')}}" class="btn btn-primary">PDF Cuadre</a>
        </div>
        <div class="form-group col-md-2"> 
            <a href="{{ route('movimientos.generatePdfMorosidad')}}" class="btn btn-primary">PDF Morosidad</a>
        </div>
        </div>
    </form>
    <div class="form-row" >  
        <div class="form-group col-md-2">    
            <label for="interes">Interes</label>
            <input type="number" id="interes" name="interes" class="form-control" placeholder="Valor a pagar"
            disabled ="true" value ="{{$interes}}"/> 
        </div>
        <div class="form-group col-md-2">    
            <label for="salida">Salida</label>
            <input type="number" id="salida" name="salida" class="form-control" placeholder="Total salida"
            disabled ="true" value ="{{$salida}}"/> 
        </div>
        <div class="form-group col-md-2">    
            <label for="entrada">Entrada</label>
            <input type="number" id="entrada" name="entrada" class="form-control" placeholder="Total Entrada"
            disabled ="true" value ="{{$entrada}}"/> 
        </div>
        <div class="form-group col-md-2">    
            <label for="total">Total</label>
            <input type="number" id="total" name="total" class="form-control" placeholder="Total"
            disabled ="true" value ="{{$total}}"/> 
        </div>
        <div class="form-group col-md-2">    
            <label for="prestamos">Prestamos</label>
            <input type="number" id="prestamos" name="prestamos" class="form-control" placeholder="prestamos"
            disabled ="true" value ="{{$pr}}"/> 
        </div>
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


    

    <script>
    window.onload = function(){
        var fecha = new Date(); //Fecha actual
        var mes = fecha.getMonth()+1; //obteniendo mes
        var dia = fecha.getDate(); //obteniendo dia
        var ano = fecha.getFullYear(); //obteniendo año
  
        if(dia<10)
            dia='0'+dia; //agrega cero si el menor de 10
        if(mes<10)
            mes='0'+mes //agrega cero si el menor de 10
        document.getElementById('fecha').value=ano+"-"+mes+"-"+dia;
    }
    </script>

@endsection