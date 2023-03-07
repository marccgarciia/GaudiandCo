<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/', [LoginController::class, 'login']);
// Route::get('/registro', [LoginController::class, 'registro']);
// Route::get('/principal', [LoginController::class, 'principal']);
Route::get('registro', [LoginController::class, 'registro']);
Route::post('loginpost', [LoginController::class, 'loginpost']);
Route::get('logout', [LoginController::class, 'logout']);
Route::get('principal', [LoginController::class, 'principal']);
Route::post('registraruser', [LoginController::class, 'registraruser']);