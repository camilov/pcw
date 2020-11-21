@extends('adminlte::page')


@section('title', 'Creacion de cliente')


@section('content')
          
          <form action="{{route('cliente.store')}}" method="POST" class="form-group form-center">

              @csrf
              <div class="form-group col-md-4">
              	<label for="nombre">Nombre</label>
              	<input type="text" id="nombre" name="nombre" class="form-control"
              	placeholder="Escribe nombre"/>
              </div>
              <br>
              <button type="submit" class="btn btn-primary">Registrar</button>

          </form>

@endsection