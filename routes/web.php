<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;

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

Route::get('/', [UsuariosController::class, 'ver']);

Route::get('/usuarios', [UsuariosController::class, 'mostrar']);
Route::get('/editar', [UsuariosController::class, 'editar']);
Route::post('/crear', [UsuariosController::class, 'crear']);
Route::post('/usuarios/{id}', [UsuariosController::class, 'update']);
Route::delete('/eliminar/{id}', [UsuariosController::class, 'delete']);
Route::get('/filtrar', [UsuariosController::class, 'filtrar']);
