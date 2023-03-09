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
            'nombre' => $request->input('nombre'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'admin' => $request->input('admin'),

        ]);
           return response()->json(['success' => true, 200]);
       }
    public function update(Request $request, $id)
   {
    try {
       $usuario = DB::table('tbl_usuarios')->where(['id' => $id]);
        if (!$usuario) {
            return response()->json(['message' => 'User not found'], 404);
        }
       $request->validate([
           'nombre' => 'required',
           'email' => 'required|email',
           'password' => 'required',
           'admin' => 'required',
       ]);

       $mod=DB::table('tbl_usuarios')
       ->where('id', $id)
       ->update([
            'nombre' => $request->input('nombre'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'admin' => $request->input('admin'),
       ]);
        return response()->json(['Resultado' => 'OK']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Ha ocurrido un error al actualizar el usuario: ' . $e->getMessage()]);
    }

}
    public function delete($id){
    $result = DB::table('tbl_usuarios')->where('id', $id)->delete();

    if ($result) {
        error_reporting(0);
        return response()->json(['message' => 'Usuario eliminado correctamente.', 200]);
    } else {
        return response()->json(['message' => 'No se pudo eliminar el usuario.']);
    }
    }
}
