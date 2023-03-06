<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('checks');
});

//MOSTRAR
Route::get('/checks', [CheckController::class, 'index']);

//INSERTAR
Route::post('/checks', [CheckController::class, 'store']);

//ACTUALIZAR
Route::put('/checks/{id}', [CheckController::class, 'update']);

//ELIMINAR
Route::delete('/checks/{id}', [CheckController::class, 'destroy']);

//BUSCAR

