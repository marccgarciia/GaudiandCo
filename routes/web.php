<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\UsuariosController;

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



//-----------------------------------------------------
//CHECKS ----------------------------------------------
//-----------------------------------------------------

//VER WEB
Route::get('/webchecks', [CheckController::class, 'webchecks'])->name('webchecks');

//MOSTRAR Y BUSCAR
Route::get('/checks', [CheckController::class, 'index']);

//INSERTAR
Route::post('/checks', [CheckController::class, 'store']);

//ACTUALIZAR
Route::put('/checks/{id}', [CheckController::class, 'update']);

//ELIMINAR
Route::delete('/checks/{id}', [CheckController::class, 'destroy']);



//-----------------------------------------------------
//CATEGORIAS ------------------------------------------
//-----------------------------------------------------

//VER WEB
Route::get('/webcategorias', [CategoriasController::class, 'webcategorias'])->name('webcategorias');

//MOSTRAR Y BUSCAR
Route::get('/categorias', [CategoriasController::class, 'indexcategorias']);

//INSERTAR
Route::post('/categorias', [CategoriasController::class, 'storecategorias']);

//ACTUALIZAR
Route::put('/categorias/{id}', [CategoriasController::class, 'updatecategorias']);

//ELIMINAR
Route::delete('/categorias/{id}', [CategoriasController::class, 'destroycategorias']);


//-----------------------------------------------------
//USUARIOS ------------------------------------------
//-----------------------------------------------------

//VER WEB
Route::get('/webusuarios', [UsuariosController::class, 'webusuarios'])->name('webusuarios');

//MOSTRAR Y BUSCAR
Route::get('/usuarios', [UsuariosController::class, 'indexusuarios']);

//INSERTAR
Route::post('/usuarios', [UsuariosController::class, 'storeusuarios']);

//ACTUALIZAR
Route::put('/usuarios/{id}', [UsuariosController::class, 'updateusuarios']);

//ELIMINAR
Route::delete('/usuarios/{id}', [UsuariosController::class, 'destroyusuarios']);

