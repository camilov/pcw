@extends('adminlte::page')


@section('title', 'Editar Tarjeta')


@section('content')
    <form action="{{route('tarjeta.update',$tarjeta)}}" method="post">

    		@csrf
    		@method('put')
    		
            <input type="text" id="idCliente"  name="idCliente" value={{$id}} hidden="true" />
              <label for="valorPrestado">Valor prestado: </label>
              <input type="number" id="valorPrestado"  name="valorPrestado"/>
              <br>
              <label for="valorTotal">Valor Total: </label>
              <input type="number" id="valorTotal" name="valorTotal"/>
              <br>
              <label for="numCuotas">Numero de cuotas: </label>
              <input type="number" id="numCuotas"  name="numCuotas"/>
              <br>
              <label for="idEstado">Estado: </label>
              <select  name="idEstado" id="idEstado">
                @foreach($estado as $estados)
                  <option value="{{$estados->idEstado}}">{{$estados->descripcion}}</option>
                @endforeach
              </select>
              <br>
              <label for="interes">Interes: </label>
              <input type="number" id="interes" name="interes" />
            <br>
            <button type="submit">Editar</button>

    </form>

@endsection