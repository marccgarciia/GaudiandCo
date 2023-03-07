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
    public function editar(Request $request){
        $modificar = DB::table('tbl_usuarios')->where(['id' => $request->id])->get();
        return response()->json($modificar);
    }
    public function crear(Request $request)
       {
           // Validamos los campos recibidos del formulario
           $request->validate([
               'nombre' => 'required',
               'email' => 'required|email',
               'password' => 'required',
               'admin' => 'required',
           ]);
         $crear = DB::table('tbl_usuarios')->insert([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => $request->password,
            'admin' => $request->admin,
        ])->post();
           // Redirigimos al listado de usuarios
           return response()->json($crear);
       }
    public function modificar(Request $request)
   {
       // Validamos los campos recibidos del formulario
       $request->validate([
           'id' => 'required',
           'nombre' => 'required',
           'email' => 'required|email',
           'password' => 'required',
           'admin' => 'required',
       ]);
       $mod = DB::table('tbl_usuarios')
      ->where('id', $request->id)
      ->update([
         'nombre' => $request->nombre,
         'email' => $request->email,
         'password' => $request->password,
         'admin' => $request->admin,
      ])->post();

       return response()->json(['message' => 'Usuario actualizado correctamente.']);
   }
    
}
