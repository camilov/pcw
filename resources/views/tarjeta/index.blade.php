@extends('adminlte::page')


@section('title', 'Lista de tarjetas')


@section('content')

    <div class="form-row" >
        <div class="form-group col-md-2">
            <div class="let">
                <h3> 
                    @foreach($cliente as $clientes)
                        {{$clientes->nombre}}
                    @endforeach
                </h3>
            </div>
        </div>
        <div class="form-group col-md-2">       
	       <a href="{{route('tarjeta.create',$id)}}" class="btn btn-info glyphicon glyphicon-plus">Nueva Tarjeta</a>
        </div>
    </div>
    <hr>
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
                    <td id ="estado" onMouseOver ="cambiar_color_out(this)">{{$tarjetas->descripcion}}</td>
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

    <style>
        .let {
            background-color:White;
            width:150px;  overflow:auto;
            text-align: center;
            border:2px solid Black;
            border-style: outset;
            border-radius: 5px;
        }
        .let h3{
            text-transform: lowercase;
            color:Black;

        }

        .let h3:first-letter {
            text-transform: uppercase;
        }
       
    </style>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
    <script type="text/javascript">
        
        function cambiar_color_out(celda){
        
            //console.log(celda.innerText);
            
            if(celda.innerText == "Pendiente")
            {  
                celda.style.backgroundColor = "#66ff33";
            }else{
                celda.style.backgroundColor = "#ff0000";
            }
        } 
        
    </script>

@endsection


