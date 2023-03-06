<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function registro()
    {
        return redirect(route('registro'));

   }
   public function login(){
       return redirect(route('login'));
   }
  
   
   public function loginpost(Request $request){
    $usuario = $request->except('_token');
    $existe = DB::table('tbl_usuarios')->where('email_user','=',$usuario['email_user'])->where('password_user', sha1($usuario['password_user']))->count();
    $admin = DB::table('tbl_usuarios')->where('admin','=',1)->where('email_user','=',$usuario['email_user'])->count();

    if ($existe == 1){
        if($admin == 1){
            $request->session()->put(['email_user',$usuario['email_user'], 'admin' => '1']);
            //TE LLEVA A LA GUIA DE RESTAURANTES
            return redirect('/guia');
        }else{
            $request->session()->put(['email_user',$usuario['email_user'], 'admin' => '0']);
            //TE LLEVA A LA GUIA DE RESTAURANTES
            return redirect('/guia');
        }
    }else{
        //TE LLEVA AL LOGUIN
        return redirect('/');
        
    } 
}

//LOGOUT
public function logout(Request $request){
    if (!$request->session()->has('email_user')){
        return redirect('/');
    } else {
        $request->session()->forget('user_user');
        // $request->session()->flush();
        return redirect('/');
    }
}
}