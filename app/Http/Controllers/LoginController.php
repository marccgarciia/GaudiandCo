<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function registro()
    {
        return redirect()->route('registro');

   }
   public function login(){
    //return "hola mundo";

    //    return view('login');
       return redirect(route('login'));
   }
   public function logout(Request $request){
    if (!$request->session()->has('email_user')){
        return redirect('/login');
    } else {
        $request->session()->forget('email_user');
        // $request->session()->flush();
        return redirect('/login');
    }

        return redirect(route('login'));
   }
   
   public function loginpost(Request $request) {
    $usuario = $request->except('_token');

    // Verificar en la base de datos que el usuario y password sea el correcto
    // si es el correcto nos redirige a la ruta donde nos muestra la tabla
    // si no volvera a /login
    $existe = DB::table('usuario')->where('email_user','=',$usuario['email_user'])->where('pass_user','=',$usuario['pass_user'])->where('pass_user','=',$usuario['admin_user'])->count();

    // Antes de redirigir necesitamos establecer una sesion
    if ($existe == 1){
        $request->session()->put('email_user',$usuario['email_user']);
        return redirect('principal');
    } else {
        return redirect('/login');
    }
} 
}

