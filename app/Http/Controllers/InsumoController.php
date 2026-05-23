<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insumo; 

class InsumoController extends Controller
{
    public function crear(Request $request) {
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'proveedor_id' => 'required|exists:proveedores,id',
            'descripcion' => 'nullable|string',
            'codigo' => 'nullable|string',
            'stock_minimo' => 'nullable|integer',
            'categoria_id' => 'nullable|integer'
        ]);

        $data = new Insumo();
        $data->nombre = $request->nombre;
        $data->proveedor_id = $request->proveedor_id; 
        $data->descripcion = $request->descripcion;
        $data->codigo = $request->codigo;
        $data->stock_minimo = $request->stock_minimo ?? 0; 
        $data->categoria_id = $request->categoria_id;

        $data->save();

        $message = ["message" => "Insumo creado con éxito", "status" => true];
        return response()->json($message);
    }

    public function actualizarPorId(Request $request) {
        $id = $request->id;
        $data = Insumo::find($id);

        $data->nombre = $request->nombre;
        $data->proveedor_id = $request->proveedor_id;
        $data->descripcion = $request->descripcion;
        $data->codigo = $request->codigo;
        $data->stock_minimo = $request->stock_minimo ?? 0;
        $data->categoria_id = $request->categoria_id;
        $data->estado_id = $request->estado_id;
        
        $data->save();
        
        $message = ["message" => "Insumo actualizado con éxito", "status" => true];
        return response()->json($message);
    }

    public function eliminarPorId($id) {
        $data = Insumo::find($id);
        $data->delete();
        
        $message = ["message" => "Insumo eliminado con éxito", "status" => true];
        return response()->json($message);
    }

       public function buscar($termino) {
        $resultados = Insumo::with('proveedor')
            ->where('nombre', 'like', '%' . $termino . '%')
            ->orWhere('codigo', 'like', '%' . $termino . '%')
            ->get();
            
        return response()->json($resultados);
    }

        public function index() {
        $insumos = Insumo::with(['proveedor', 'estado'])->get(); 
        return response()->json($insumos);
    }
}