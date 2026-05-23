<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area; 

class AreaController extends Controller
{
    public function obtenerTodos() {
        $areas = Area::all();
        return response()->json($areas);
    }

    public function crear(Request $request) {
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $data = new Area();
        $data->nombre = $request->nombre;
        $data->descripcion = $request->descripcion;

        $data->save();

        $message = ["message" => "Área creada con éxito", "status" => true];
        return response()->json($message);
    }

    public function actualizarPorId(Request $request) {
        $id = $request->id;
        $data = Area::find($id);
        
        if (!$data) {
            return response()->json(["message" => "Área no encontrada", "status" => false], 404);
        }
        
        $data->nombre = $request->nombre;
        $data->descripcion = $request->descripcion;
        $data->estado_id = $request->estado_id;
        
        $data->save();
        
        $message = ["message" => "Área actualizada con éxito", "status" => true];
        return response()->json($message);
    }

    public function eliminarPorId($id) {
        $data = Area::find($id);
        
        if ($data) {
            $data->delete();
            $message = ["message" => "Área eliminada con éxito", "status" => true];
        } else {
            $message = ["message" => "Área no encontrada", "status" => false];
        }
        
        return response()->json($message);
    }

    public function obtenerPorId($id) {
        $data = Area::find($id);
        
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(["message" => "Área no encontrada", "status" => false], 404);
        }
    }

    public function buscar($termino) {
        // Busca coincidencias en nombre, descripción o coincidencia exacta en ID
        $resultados = Area::where('nombre', 'like', '%' . $termino . '%')
            ->orWhere('descripcion', 'like', '%' . $termino . '%')
            ->orWhere('estado_id', $termino )
            ->orWhere('id', $termino)
            ->get();
            
        return response()->json($resultados);
    }
}  