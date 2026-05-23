<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ubicacion; 

class UbicacionController extends Controller
{
    public function obtenerTodos() {
        $ubicaciones = Ubicacion::all();
        return response()->json($ubicaciones);
    }

    public function crear(Request $request) {
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $data = new Ubicacion();
        $data->nombre = $request->nombre;
        $data->descripcion = $request->descripcion;

        $data->save();

        $message = ["message" => "Ubicación creada con éxito", "status" => true];
        return response()->json($message);
    }

    public function actualizarPorId(Request $request) {
        $id = $request->id;
        $data = Ubicacion::find($id);
        
        if (!$data) {
            return response()->json(["message" => "Ubicación no encontrada", "status" => false], 404);
        }
        
        $data->nombre = $request->nombre;
        $data->descripcion = $request->descripcion;
        $data->estado_id = $request->estado_id;
        
        $data->save();
        
        $message = ["message" => "Ubicación actualizada con éxito", "status" => true];
        return response()->json($message);
    }

    public function eliminarPorId($id) {
        $data = Ubicacion::find($id);
        
        if ($data) {
            $data->delete();
            $message = ["message" => "Ubicación eliminada con éxito", "status" => true];
        } else {
            $message = ["message" => "Ubicación no encontrada", "status" => false];
        }
        
        return response()->json($message);
    }

    public function obtenerPorId($id) {
        $data = Ubicacion::find($id);
        
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(["message" => "Ubicación no encontrada", "status" => false], 404);
        }
    }

    public function buscar($termino) {
        // Busca coincidencias en nombre, descripción o coincidencia exacta en ID
        $resultados = Ubicacion::where('nombre', 'like', '%' . $termino . '%')
            ->orWhere('descripcion', 'like', '%' . $termino . '%')
            ->orWhere('id', $termino)
            ->get();
            
        return response()->json($resultados);
    }
}  