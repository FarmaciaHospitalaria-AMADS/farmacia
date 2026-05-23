<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria; 

class CategoriaController extends Controller
{
    public function obtenerTodos() {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }

    public function crear(Request $request) {
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $data = new Categoria();
        $data->nombre = $request->nombre;
        $data->descripcion = $request->descripcion;

        $data->save();

        $message = ["message" => "Categoría creada con éxito", "status" => true];
        return response()->json($message);
    }

    public function actualizarPorId(Request $request) {
        $id = $request->id;
        $data = Categoria::find($id);
        
        if (!$data) {
            return response()->json(["message" => "Categoría no encontrada", "status" => false], 404);
        }
        
        $data->nombre = $request->nombre;
        $data->descripcion = $request->descripcion;
        $data->estado_id = $request->estado_id;
        
        $data->save();
        
        $message = ["message" => "Categoría actualizada con éxito", "status" => true];
        return response()->json($message);
    }

    public function eliminarPorId($id) {
        $data = Categoria::find($id);
        
        if ($data) {
            $data->delete();
            $message = ["message" => "Categoría eliminada con éxito", "status" => true];
        } else {
            $message = ["message" => "Categoría no encontrada", "status" => false];
        }
        
        return response()->json($message);
    }

    public function obtenerPorId($id) {
        $data = Categoria::find($id);
        
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(["message" => "Categoría no encontrada", "status" => false], 404);
        }
    }

    public function buscar($termino) {
        // Busca coincidencias en nombre, descripción o coincidencia exacta en ID
        $resultados = Categoria::where('nombre', 'like', '%' . $termino . '%')
            ->orWhere('descripcion', 'like', '%' . $termino . '%')
            ->orWhere('id', $termino)
            ->get();
            
        return response()->json($resultados);
    }
}  