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
Route::resource('cliente','App\Http\Controllers\ClientesController');
Route::get('cliente/{ID}/destroy',[
	       'uses' => 'App\Http\Controllers\ClientesController@destroy',
	        'as'  => 'cliente.destroy'
	    ]);

/*-----------------------------TARJETAS--------------------------*/
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

/*-----------------------------ABONO--------------------------*/
Route::resource('abono','App\Http\Controllers\AbonosController');

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