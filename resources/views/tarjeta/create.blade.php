@extends('adminlte::page')


@section('title', 'Creacion de tarjeta')


@section('content')
          
          <form action="{{route('tarjeta.store')}}" method="POST">
              @csrf
              <input type="text" id="idCliente"  name="idCliente" value={{$id}} hidden="true" />
              <div class="form-row" >
                <div class="form-group col-md-4">
                  <label for="valorPrestado">Valor prestado</label>
                  <input type="number" id="valorPrestado"  name="valorPrestado"
                  class="form-control" placeholder="Escribe valor prestado"/>
                </div>
                <div class="form-group col-md-4">
                  <label for="valorTotal">Valor Total</label>
                  <input type="number" id="valorTotal" name="valorTotal"
                  class="form-control" placeholder="Escribe valor total" value="0"/>
                </div>
              </div>
              <div class="form-row" >
                <div class="form-group col-md-4">
                  <label for="fechaPrestamo">Fecha prestamo</label>
                  <input type="date" id="fechaPrestamo" name="fechaPrestamo" value="<?php echo date('Y-m-d'); ?>"
                  class="form-control"/>
                </div>
                <div class="form-group col-md-4">
                  <label for="numCuotas">Numero de cuotas: </label>
                  <input type="number" id="numCuotas"  name="numCuotas"
                  class="form-control" placeholder="Escribe numero de cuotas" value="0"/>
                </div>
              </div>
              <div class="form-row" >
                <div class="form-group col-md-4">
                  <label for="idEstado">Estado</label>
                  <select  name="idEstado" id="idEstado" class="form-control">
                    @foreach($estado as $estados)
                      <option value="{{$estados->idEstado}}">{{$estados->descripcion}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="idInteres">Interes</label>
                  <select  name="idInteres" id="idInteres" class="form-control">
                    @foreach($porcentaje as $porcentajes)
                      <option value="{{$porcentajes->idPorcentaje}}">{{$porcentajes->porcentaje}}</option>
                    @endforeach
                  </select>
                </div>
                
              </div>
              <div class="form-row" >
                <div class="form-group col-md-4">
                  <label for="valorDefecto">Valor defecto</label>
                  <input type="number" id="valorDefecto" name="valorDefecto" 
                  class="form-control" placeholder="Escribe valor por defecto" value="0"/>
                </div>
              </div>  
              <br>
              <button type="submit" class="btn btn-primary">Registrar</button>
          </form>


@endsection