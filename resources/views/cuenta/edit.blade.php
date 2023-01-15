@extends('adminlte::page')


@section('title', 'Ajuste')


@section('content')
    <form action="{{route('cuenta.update',$movimiento)}}" method="post">

    		@csrf
    		@method('put')
        <div class="form-row" >
          <div class="form-group col-md-4">
            <label for="valor">Valor</label>
            <input type="number" id="valor" name="valor" 
            class="form-control" value="{{$movimiento->salida}}"/>
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