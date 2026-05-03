<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    // Función para LISTAR todos los proveedores
    public function obtenerTodos() {
        $list = Proveedor::all();
        return response()->json($list);
    }

    // Función para CREAR un nuevo proveedor
    public function crear(Request $request) {
        $data = new Proveedor();
        
        // Asignamos los datos que vienen desde la petición (Postman o la web)
        $data->nombre = $request->nombre;
        $data->telefono = $request->telefono;
        $data->email = $request->email;
        $data->direccion = $request->direccion;
        
        // Si pusiste el campo contacto en la migración, descomenta la siguiente línea:
        // $data->contacto = $request->contacto; 

        $data->save();

        $message = ["message" => "Proveedor creado con éxito", "status" => true];
        return response()->json($message);
    }

    public function actualizarPorId(Request $request) {
        $id = $request->id;
        
        $data = Proveedor::find($id);
        
        // Le pasamos los nuevos valores
        $data->nombre = $request->nombre;
        $data->telefono = $request->telefono;
        $data->email = $request->email;
        $data->direccion = $request->direccion;
        
        $data->save();
        
        $message = ["message" => "Proveedor actualizado con éxito", "status" => true];
        return response()->json($message);
    }

    public function eliminarPorId($id) {
        $data = Proveedor::find($id);
        
        // Eliminamos el registro
        $data->delete();
        
        // Enviamos la respuesta
        $message = ["message" => "Proveedor eliminado con éxito", "status" => true];
        return response()->json($message);
    }
}