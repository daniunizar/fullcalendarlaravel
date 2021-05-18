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
    return view('welcome');
});

Auth::routes();

// Route::get('/event', [App\Http\Controllers\EventController::class, 'index']);
// Route::post('/event/crear', [App\Http\Controllers\EventController::class, 'store'])->name('event.create');
Route::get('/index', [App\Http\Controllers\EventController::class, 'index']);
Route::get('user', [App\Http\Controllers\UserController::class, 'index'])->name('user');;
Route::get('event/list', array('as'=>'event.list', 'uses'=>'App\Http\Controllers\EventController@list'));//Ruta añadida como complemento a event para listar los eventos
Route::post('event/actualizar', array('as'=>'event.actualizar', 'uses'=>'App\Http\Controllers\EventController@actualizar'));//Ruta añadida como complemento a event para listar los eventos
Route::post('event/destruir', array('as'=>'event.destruir', 'uses'=>'App\Http\Controllers\EventController@destruir'));//Ruta añadida como complemento a event para eliminar los eventos
Route::post('event/listar_asistentes', array('as'=>'event.listar_asistentes', 'uses'=>'App\Http\Controllers\EventController@listar_asistentes'));//Ruta añadida como complemento a event para listar asistentes a los eventos
Route::post('events_users/pintar_asistentes', array('as'=>'events_users.pintar_asistentes', 'uses'=>'App\Http\Controllers\EventsUsersController@pintar_asistentes'));//Ruta añadida como complemento a event para listar asistentes a los eventos

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/event', App\Http\Controllers\EventController::class);
