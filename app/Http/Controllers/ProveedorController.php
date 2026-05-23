<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    public function obtenerTodos() {
        $list = Proveedor::all();
        return response()->json($list);
    }

    public function crear(Request $request) {
        $data = new Proveedor();
        
        $data->nombre = $request->nombre;
        $data->telefono = $request->telefono;
        $data->email = $request->email;
        $data->direccion = $request->direccion;

        $data->save();

        $message = ["message" => "Proveedor creado con éxito", "status" => true];
        return response()->json($message);
    }

    public function actualizarPorId(Request $request) {
        $id = $request->id;
        
        $data = Proveedor::find($id);
        
        $data->nombre = $request->nombre;
        $data->telefono = $request->telefono;
        $data->email = $request->email;
        $data->direccion = $request->direccion;
        $data->estado_id = $request->estado_id;
        
        $data->save();
        
        $message = ["message" => "Proveedor actualizado con éxito", "status" => true];
        return response()->json($message);
    }

    public function eliminarPorId($id) {
        $data = Proveedor::find($id);
        
        $data->delete();
        
        $message = ["message" => "Proveedor eliminado con éxito", "status" => true];
        return response()->json($message);
    }

        public function index() {
        $proveedores = Proveedor::with('estado')->get(); 
        return response()->json($proveedores);
    }
}