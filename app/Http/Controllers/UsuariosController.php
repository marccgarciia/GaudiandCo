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
    public function update(Request $request, $id)
   {
   try {
       $usuario = DB::table('tbl_usuarios')->where(['id' => $id])->get();
        if (!$usuario) {
            return response()->json(['message' => 'User not found'], 404);
        }
       // Validamos los campos recibidos del formulario
       $request->validate([
           'nombre' => 'required',
           'email' => 'required|email',
           'password' => 'required',
           'admin' => 'required',
       ]);

       $mod=DB::table('tbl_usuarios')
       ->where('id', $id)
       ->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => $request->password,
            'admin' => $request->admin,
       ]);

       return response()->json($mod);
   } catch (\Exception $e) {
       return response()->json(['error' => 'Ha ocurrido un error al actualizar el usuario: ' . $e->getMessage()]);
   }

}
    public function delete($id){
    $result = DB::table('tbl_usuarios')->where('id', $id)->delete();

    if ($result) {
        return response()->json(['message' => 'Usuario eliminado correctamente.']);
    } else {
        return response()->json(['message' => 'No se pudo eliminar el usuario.']);
    }
    }
}
