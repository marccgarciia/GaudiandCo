<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Checks;
use App\Models\Categorias;



class CheckController extends Controller
{

    // CONTROLADOR PARA LLEVAR A LA WEB
    public function webchecks()
    {
        return view('checks');
    }
            

    // CONTROLADOR PARA MOSTRAR DATOS
    public function index()
    {
        $checks = Checks::join('tbl_categorias', 'tbl_checks.categoria_id', '=', 'tbl_categorias.id')
            ->select('tbl_checks.*', 'tbl_categorias.nombre as categoria')
            ->get();
        return response()->json($checks);
    }


    // CONTROLADOR PARA MOSTRAR DATOS
    // public function index()
    // {
    //     $checks = Checks::all();
    //     return response()->json($checks);
    // }

    // CONTROLADOR PARA INSERTAR DATOS CON VALIDACION DE CAMPOS VACIOS/FORMATO E-MAIL/E-MAIL EXISTENTE
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
            'categoria_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $check = new Checks;
        $check->nombre = $request->nombre;
        $check->descripcion = $request->descripcion;
        $check->latitud = $request->latitud;
        $check->longitud = $request->longitud;
        $check->categoria_id = $request->categoria_id;
        $check->save();

        return response()->json($check);
    }

    // CONTROLADOR PARA EDITAR DATOS CON VALIDACION DE CAMPOS VACIOS/FORMATO E-MAIL/E-MAIL EXISTENTE
    public function update(Request $request, $id)
    {
        $check = Checks::find($id);
        if (!$check) {
            return response()->json(['message' => 'Check not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'required',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'categoria_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $check->nombre = $request->nombre;
        $check->descripcion = $request->descripcion;
        $check->latitud = $request->latitud;
        $check->longitud = $request->longitud;
        $check->categoria_id = $request->categoria_id;
        $check->save();

        return response()->json($check);
    }

    // CONTROLADOR PARA ELIMINAR DATOS
    public function destroy($id)
    {
        $check = Checks::findOrFail($id);
        $check->delete();
        return response()->json(['message' => 'Check deleted']);
    }
}
