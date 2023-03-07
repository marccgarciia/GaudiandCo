<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;



use Illuminate\Http\Request;

class LoginController extends Controller
{

    //REDIRECCIONES DE PÁGINAS

   public function login(){
        return view('login');
   }

   public function registro(){
    return view('registro');
}
  
   //COMPROBAR LOGIN
   public function loginpost(Request $request){
    $email=$request->input('email');
    $password=$request->input('password');

    $usuario = $request->except('_token');
    $existe = DB::table('tbl_usuarios')->where('email','=',$usuario['email'])->where('password', sha1($usuario['password']))->count();
    $admin = DB::table('tbl_usuarios')->where('admin','=',1)->where('email','=',$usuario['email'])->count();

    if ($existe == 1){
        if($admin == 1){
            $request->session()->put(['email',$usuario['email'], 'admin' => '1']);
            //TE LLEVA A LA GUIA DE RESTAURANTES
            return redirect('principal');
        }else{
            $request->session()->put(['email',$usuario['email'], 'admin' => '0']);
            //TE LLEVA A LA GUIA DE RESTAURANTES
            return redirect('principal');
        }
    }else{
        //TE LLEVA AL LOGIN
        return redirect('/');
        
    } 
}



public function registraruser(Request $request) {
    $email=$request->input('email');
    $password=$request->input('password');

//CAMBIOS
$usuarios = $request->except('_token');
$existeuser = DB::table('tbl_usuarios')->where('email','=',$usuarios['email'])->count();
if($existeuser == 0){
    //COMPROBAR SI EL USUARIO YA EXISTE
        DB::table('usuarios')->insert([
            // 'id'=> '6',
            'email' => $email,
            'password' => $password,
            'admin' => '0',
            ]);

            return redirect('/');
}else{
    return redirect('registro');
}

//CAMBIOS
}
//FINALCAMBIOS


//LOGOUT 
// public function logout(Request $request){
//     if (!$request->session()->has('email')){
//         return redirect('/');
//     } else {
//         $request->session()->forget('user');
//         // $request->session()->flush();
//         return redirect('/');
//     }
// }
 }