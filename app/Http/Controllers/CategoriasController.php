<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Categoria;

class CategoriasController extends Controller
{

        // CONTROLADOR PARA LLEVAR A LA WEB
        public function webcategorias()
        {
            return view('categorias');
        }
        

      // CONTROLADOR PARA MOSTRAR DATOS
      public function indexcategorias()
      {
          $categorias = Categoria::all();
          return response()->json($categorias);
      }
  

      // CONTROLADOR PARA INSERTAR DATOS CON VALIDACION DE CAMPOS VACIOS/FORMATO E-MAIL/E-MAIL EXISTENTE
      public function storecategorias(Request $request)
      {
          $validator = Validator::make($request->all(), [
              'nombre' => 'required',
          ]);
  
          if ($validator->fails()) {
              return response()->json(['errors' => $validator->errors()], 422);
          }
  
          $categoria = new Categoria;
          $categoria->nombre = $request->nombre;
          $categoria->save();
  
          return response()->json($categoria);
      }
  
      // CONTROLADOR PARA EDITAR DATOS CON VALIDACION DE CAMPOS VACIOS/FORMATO E-MAIL/E-MAIL EXISTENTE
      public function updatecategorias(Request $request, $id)
      {
          $categoria = Categoria::find($id);
          if (!$categoria) {
              return response()->json(['message' => 'Categoria not found'], 404);
          }
  
          $validator = Validator::make($request->all(), [
              'nombre' => 'required',
          ]);
  
          if ($validator->fails()) {
              return response()->json(['errors' => $validator->errors()], 422);
          }
  
          $categoria->nombre = $request->nombre;
          $categoria->save();
  
          return response()->json($categoria);
      }
  
      // CONTROLADOR PARA ELIMINAR DATOS
      public function destroycategorias($id)
      {
          $categoria = Categoria::findOrFail($id);
          $categoria->delete();
          return response()->json(['message' => 'Categoria deleted']);
      }

}