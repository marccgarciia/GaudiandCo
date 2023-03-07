<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;


Route::get('/', [LoginController::class, 'login']);

Route::post('loginpost', [LoginController::class, 'loginpost']);
Route::get('logout', [LoginController::class, 'logout']);
Route::get('principal', [LoginController::class, 'principal']);
Route::post('registraruser', [LoginController::class, 'registraruser']);
Route::get('/registro', [LoginController::class, 'registro'])->name('registro');