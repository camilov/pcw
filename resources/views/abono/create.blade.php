@extends('adminlte::page')


@section('title', 'Creacion de abono')


@section('content')

          <form action="{{route('abono.store')}}" method="POST">
              @csrf
              <input type="text" id="idTarjeta"  name="idTarjeta" value={{$id}} hidden="true" />
              
              <input type="number" id="valorFinal" name="valorFinal" 
                  class="form-control" placeholder="Escribe valor por defecto" value="{{$valorFinal}}" hidden="true"/>
              
              <div class="form-row" >
                <div class="form-group col-md-2">
                  <label for="numCuota">N° Cuotas</label>
                  <input type="number" id="numCuota"  name="numCuota" 
                  class="form-control" value="1" onchange="sumar()"/>
                </div>
                <div class="form-group col-md-2">
                  <label for="valorAbono">Valor Abono</label>
                  <input type="number" id="valorAbono"  name="valorAbono"
                  class="form-control" value="{{$valorFinal}}"/>  
                
                </div>
                <!--<div class="form-group col-md-4">
                  <label for="fechaAbono">Fecha Abono</label>
                  <input type="date" id="fechaAbono" name="fechaAbono" value="<?php echo date('Y-m-d'); ?>" 
                  class="form-control" class="form-control" />
                </div>-->
              </div>
              <br>
              <button type="submit" class="btn btn-primary">Registrar</button>
          </form>
          <script>
            function sumar () 
            {  
              var total = 0;  
              cuota = parseInt(document.getElementById('numCuota').value); 
              valorDefecto = parseInt(document.getElementById('valorFinal').value);
  
              total = cuota * valorDefecto;

              total = parseInt(total);

              document.getElementById('valorAbono').value = total;
            }
        </script>
          
@endsection