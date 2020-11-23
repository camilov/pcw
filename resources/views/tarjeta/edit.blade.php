@extends('adminlte::page')


@section('title', 'Editar Tarjeta')


@section('content')
    <form action="{{route('tarjeta.update',$tarjeta)}}" method="post">

    		@csrf
    		@method('put')
    		<input type="text" id="idCliente"  name="idCliente" value={{$idCliente}} hidden="true" />
        <div class="form-row" >
          <div class="form-group col-md-4">      
              <label for="idEstado">Estado: </label>
              <select  name="idEstado" id="idEstado">
                @foreach($estado as $estados)
                  <option value="{{$estados->idEstado}}">{{$estados->descripcion}}</option>
                @endforeach
              </select>
          </div>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Editar</button>

    </form>

@endsection