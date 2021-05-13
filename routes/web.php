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
Route::resource('/event', App\Http\Controllers\EventController::class);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
