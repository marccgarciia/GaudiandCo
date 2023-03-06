<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Usuarios;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function ver(){
        return view('usuarios');
    }
    public function mostrar(Request $request){
        $usuarios = DB::table('tbl_usuarios')->get();
        return response()->json($usuarios);
    }
    
}
