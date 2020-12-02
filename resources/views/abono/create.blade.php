@extends('adminlte::page')


@section('title', 'Creacion de abono')


@section('content')
          
          <form action="{{route('abono.store')}}" method="POST">
              @csrf
              <input type="text" id="idTarjeta"  name="idTarjeta" value={{$id}} hidden="true" />
              <div class="form-row" >
                <div class="form-group col-md-2">
                  <label for="valorAbono">Valor Abono</label>
                  <input type="number" id="valorAbono"  name="valorAbono"
                  class="form-control" value="0"/>
                </div>
                <div class="form-group col-md-2">
                  <label for="numCuota">N° Cuota</label>
                  <input type="number" id="numCuota"  name="numCuota" 
                  class="form-control" value="1"/>
                </div>
                <div class="form-group col-md-4">
                  <label for="fechaAbono">Fecha Abono</label>
                  <input type="date" id="fechaAbono" name="fechaAbono" value="<?php echo date('Y-m-d'); ?>" 
                  class="form-control" class="form-control" />
                </div>
              </div>
              <br>
              <button type="submit" class="btn btn-primary">Registrar</button>
          </form>


@endsection