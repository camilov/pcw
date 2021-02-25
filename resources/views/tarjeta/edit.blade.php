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
        <div class="form-row" >
          <div class="form-group col-md-4">
            <label for="valorDefecto">Valor defecto</label>
            <input type="number" id="valorDefecto" name="valorDefecto" 
            class="form-control" placeholder="Escribe valor por defecto" value="{{$tarjeta->valorDefecto}}"/>
          </div>
        </div>
        <label for="valorDefecto">¿Voltear tarjeta?</label>
        <hr>
        <div class="form-row" >
          <div class="form-group col-md-4">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="voltear"  value="s" checked
               id="vols">
              <label class="form-check-label" for="voltear">
                Si
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="voltear" value="n" checked
               id="voln">
              <label class="form-check-label" for="voltear">
                No
              </label>
            </div>
          </div>
        </div>
        <label for="valorDefecto">¿valor especial?</label>
        <hr>
        <div class="form-row" >
          <div class="form-group col-md-4">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="especial" value="s" checked>
              <label class="form-check-label" for="especial">
                Si
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="especial" value="n" checked>
              <label class="form-check-label" for="especial">
                No
              </label>
            </div>
          </div>
        </div>
        <hr>
        <div class="form-row" >
          <div class="form-group col-md-4">
            <input type="number" id="nuevoValor" name="nuevoValor" 
            class="form-control" placeholder="Escribe nuevo valor de tarjeta" />
          </div>
        </div>
        <div class="form-row" >
          <div class="form-group col-md-4">
            <input type="number" id="nuevoValorDefecto" name="nuevoValorDefecto" 
            class="form-control" placeholder="Escribe nuevo valor de defecto" />
          </div>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Editar</button>

    </form>

    <style type="text/css">


    </style>

    <script type="text/javascript">
      
      function handleClick(){

        if (document.getElementById('vols').checked)
    {
      alert('no tienes estudios');
    }else
      }

    </script>

@endsection