<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;



class LoginController extends Controller
{
    //REDIRECCIONES DE PÁGINAS
    //Login
    public function login(){
        return view('login');
    }
    //Registro
    public function registro()
    {
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

































}


