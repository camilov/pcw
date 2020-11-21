@extends('adminlte::page')


@section('title', 'Editar cliente')


@section('content')
    <form action="{{route('cliente.update',$cliente)}}" method="post">

    		@csrf
    		@method('put')
    		<div class="form-group col-md-4">
              <label for="nombre">Nombre</label>
              <input type="text" id="nombre" name="nombre" value = "{{$cliente->nombre}}" class="form-control" placeholder="Escribe nombre"/>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Editar</button>

    </form>

@endsection