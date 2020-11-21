@extends('adminlte::page')


@section('title', 'Lista de clientes')


@section('content')

    <div class="form-row" >   
        <div class="form-group col-md-4">                    
	       <a href="{{route('cliente.create')}}" class="btn btn-info glyphicon glyphicon-plus">Registrar Cliente</a>
        </div>
        <form action="{{route('cliente.index')}}" method="GET" class="form-group form-center">

              @csrf
              <div class="form-group col-md-8">
                <label for="nombre">Buscar</label>
                <input type="text" id="nombre" name="nombre" class="form-control"
                placeholder="Escribe nombre" aria-describedby="search"/>
              </div>

        </form>
    </div>
    <br>
	<table class="table table-sm table-condensed table-striped table-bordered col-md-6" id="exTable">
        <thead class="tableThead thead-dark">
            <th scope="col">Nombre</th>
            <th scope="col">Acciones</th>
        </thead>
        <tbody>
            @foreach($cliente as $clientes)
                <tr>
                    <td>{{$clientes->nombre}}</td>
                    <td>
                    <a href="{{route('cliente.edit',$clientes->idCliente)}}" class="fa fa-wrench"></a>
                    <a href="{{route('cliente.destroy',$clientes->idCliente)}}" onclick="return confirm('¿Seguro que deseas eliminar el cliente?')" class="fa fa-trash"></a>
                    <a href="{{route('tarjeta.index',$clientes->idCliente)}}" class="fa fa-id-card"></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
            {!! $cliente->links() !!}




@endsection