<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estado; 

class EstadoController extends Controller
{
    public function obtenerTodos() {
        $estados = Estado::all();
        return response()->json($estados);
    }

    public function obtenerPorId($id) {
        $data = Estado::find($id);
        
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(["message" => "Estado no encontrado", "status" => false], 404);
        }
    }

    public function crear(Request $request) {
        
        $request->validate([
            'nombre' => 'required|string|max:255|unique:estados,nombre', // unique para no tener dos estados con el mismo nombre
        ]);

        $data = new Estado();
        $data->nombre = $request->nombre;

        $data->save();

        $message = ["message" => "Estado creado con éxito", "status" => true];
        return response()->json($message);
    }

    public function actualizarPorId(Request $request) {
        $id = $request->id;
        $data = Estado::find($id);
        
        if (!$data) {
            return response()->json(["message" => "Estado no encontrado", "status" => false], 404);
        }
        
        // Validar que el nuevo nombre no exista ya (ignorando el ID actual)
        $request->validate([
            'nombre' => 'required|string|max:255|unique:estados,nombre,' . $id,
        ]);
        
        $data->nombre = $request->nombre;
        
        $data->save();
        
        $message = ["message" => "Estado actualizado con éxito", "status" => true];
        return response()->json($message);
    }

    public function eliminarPorId($id) {
        $data = Estado::find($id);
        
        if ($data) {
            $data->delete();
            $message = ["message" => "Estado eliminado con éxito", "status" => true];
        } else {
            $message = ["message" => "Estado no encontrado", "status" => false];
        }
        
        return response()->json($message);
    }

    public function buscar($termino) {
        // Busca coincidencias en nombre o coincidencia exacta en ID
        $resultados = Estado::where('nombre', 'like', '%' . $termino . '%')
            ->orWhere('id', $termino)
            ->get();
            
        return response()->json($resultados);
    }
}