<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Checks;
use App\Models\Categorias;
use App\Models\Usuarios;



class UsuariosController extends Controller
{

    // CONTROLADOR PARA LLEVAR A LA WEB
    public function webusuarios()
    {
        return view('usuarios');
    }
            


    // CONTROLADOR PARA MOSTRAR DATOS
    public function indexusuarios()
    {
        $usuarios = Usuarios::all();
        return response()->json($usuarios);
    }


    // CONTROLADOR PARA INSERTAR DATOS CON VALIDACION DE CAMPOS VACIOS/FORMATO E-MAIL/E-MAIL EXISTENTE
    public function storeusuarios(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|alpha',
            'email' => 'required|email',
            'pswd' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $usuario = new Usuarios;
        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->pswd = bcrypt($request->pswd);
        $usuario->save();

        return response()->json($usuario);
    }

    // CONTROLADOR PARA EDITAR DATOS CON VALIDACION DE CAMPOS VACIOS/FORMATO E-MAIL/E-MAIL EXISTENTE
    public function updateusuarios(Request $request, $id)
    {
        $usuario = Usuarios::find($id);
        if (!$usuario) {
            return response()->json(['message' => 'Usuario not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|alpha',
            'email' => 'required|email',
            'pswd' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->pswd = bcrypt($request->pswd);
        $usuario->save();

        return response()->json($usuario);
    }

    // CONTROLADOR PARA ELIMINAR DATOS
    public function destroyusuarios($id)
    {
        $usuario = Usuarios::findOrFail($id);
        $usuario->delete();
        return response()->json(['message' => 'Usuario deleted']);
    }
}
