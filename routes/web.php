<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*-----------------------------CLIENTES--------------------------*/
//Route::resource('cliente','App\Http\Controllers\ClientesController');
Route::get('cliente/index',[
	'uses' => 'App\Http\Controllers\ClientesController@index',
	 'as'  => 'cliente.index'
 ]);

 Route::get('cliente/create',[
	'uses' => 'App\Http\Controllers\ClientesController@create',
	 'as'  => 'cliente.create'
 ]);

Route::get('cliente/{ID}/edit',[
	'uses' => 'App\Http\Controllers\ClientesController@edit',
	 'as'  => 'cliente.edit'
 ]);


Route::get('cliente/{ID}/destroy',[
	       'uses' => 'App\Http\Controllers\ClientesController@destroy',
	        'as'  => 'cliente.destroy'
	    ]);

Route::put('cliente/{ID}',[
			'uses' => 'App\Http\Controllers\ClientesController@update',
			 'as'  => 'cliente.update'
		 ]);
 Route::post('cliente/store',[
			'uses' => 'App\Http\Controllers\ClientesController@store',
			 'as'  => 'cliente.store'
		 ]);
 //Route::post('store', 'App\Http\Controllers\ClientesController@store')->name("cliente.store");

/*-------------------------------TARJETAS--------------------------*/
//Route::resource('tarjeta','App\Http\Controllers\TarjetasController');

Route::get('tarjeta/{ID}/index',[
	       'uses' => 'App\Http\Controllers\TarjetasController@index',
	        'as'  => 'tarjeta.index'
	    ]);

Route::get('tarjeta/{ID}/create',[
	       'uses' => 'App\Http\Controllers\TarjetasController@create',
	        'as'  => 'tarjeta.create'
	    ]);

Route::get('tarjeta/{ID},{idCliente}/edit',[
	       'uses' => 'App\Http\Controllers\TarjetasController@edit',
	        'as'  => 'tarjeta.edit'
	    ]);


Route::get('tarjeta/{ID},{idCliente}/destroy',[
	       'uses' => 'App\Http\Controllers\TarjetasController@destroy',
	        'as'  => 'tarjeta.destroy'
	    ]);

Route::put('tarjeta/{ID}',[
	       'uses' => 'App\Http\Controllers\TarjetasController@update',
	        'as'  => 'tarjeta.update'
	    ]);

Route::post('store', 'App\Http\Controllers\TarjetasController@store')->name("tarjeta.store");

/*-----------------------------ABONO--------------------------*/
//Route::resource('abono','App\Http\Controllers\AbonosController');

Route::get('abono/{ID}/index',[
	       'uses' => 'App\Http\Controllers\AbonosController@index',
	        'as'  => 'abono.index'
	    ]);

Route::get('abono/{ID}/create',[
	       'uses' => 'App\Http\Controllers\AbonosController@create',
	        'as'  => 'abono.create'
	    ]);

Route::get('abono/{ID},{idTarjeta}/destroy',[
	       'uses' => 'App\Http\Controllers\AbonosController@destroy',
	        'as'  => 'abono.destroy'
	    ]);

Route::post('abono/store',[
			'uses' => 'App\Http\Controllers\AbonosController@store',
			 'as'  => 'abono.store'
		 ]);

Route::get('abono/{ID}/edit',[
			'uses' => 'App\Http\Controllers\AbonosController@edit',
			 'as'  => 'abono.edit'
		 ]);
/*-----------------------------CUENTAS--------------------------*/
//Route::resource('cuenta','App\Http\Controllers\CuentasController');

Route::get('cuenta/index',[
	'uses' => 'App\Http\Controllers\CuentasController@index',
	 'as'  => 'cuenta.index'
 ]);


Route::get('cuenta/{idMovimiento}/edit',[
	'uses' => 'App\Http\Controllers\CuentasController@edit',
	 'as'  => 'cuenta.edit'
 ]);

 Route::put('cuenta/{ID}',[
	'uses' => 'App\Http\Controllers\CuentasController@update',
	 'as'  => 'cuenta.update'
 ]);

/*-----------------------------------------------------------------*/
/*---------------------------Movimientos----------------------------*/
//Route::resource('movimientos','App\Http\Controllers\MovimientosController');

Route::get('movimientos/index',[
	'uses' => 'App\Http\Controllers\MovimientosController@index',
	 'as'  => 'movimientos.index'
 ]);

 Route::get('movimientos/generatePDF',[
	'uses' => 'App\Http\Controllers\MovimientosController@generatePDF',
	 'as'  => 'movimientos.generatePDF'
 ]);

 Route::get('movimientos/generatePdfMorosidad',[
	'uses' => 'App\Http\Controllers\MovimientosController@generatePdfMorosidad',
	 'as'  => 'movimientos.generatePdfMorosidad'
 ]);

 /*---------------------------Consultas----------------------------*/
Route::resource('consultas','App\Http\Controllers\ConsultasController');
//Route::get('/generate-pdf', 'PDFController@generatePDF');
