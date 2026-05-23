<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role; // Asegúrate de importar el modelo Role
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 1. Obtener todos los usuarios
    public function index() {
        // Traemos los usuarios sin cargar la contraseña en el JSON por seguridad
        $usuarios = User::all();
        return response()->json($usuarios);
    }

    // 2. Obtener la lista de roles para el formulario
    public function obtenerRoles() {
        $roles = Role::all();
        return response()->json($roles);
    }

    // 3. Crear Usuario
    public function crear(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'estado_id' => 'required|integer'
        ]);

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password); // Encriptación segura
        $usuario->role_id = $request->role_id;
        $usuario->estado_id = $request->estado_id;

        $usuario->save();

        return response()->json(["message" => "Usuario creado con éxito", "status" => true]);
    }

    // 4. Actualizar Usuario
    public function actualizarPorId(Request $request) {
            $request->validate([
                'id' => 'required|exists:users,id',
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $request->id,
                'role_id' => 'required|exists:roles,id',
                'estado_id' => 'required|integer'
            ]);

            // PROTECCIÓN ESTRICTA: El usuario en sesión no puede actualizar su propio perfil desde esta vista
            if ($request->id == Auth::id()) {
                return response()->json([
                    "message" => "Acción denegada: Por seguridad, no puedes modificar tu propia cuenta desde la gestión de usuarios.", 
                    "status" => false
                ], 403);
            }

            $usuario = User::find($request->id);
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->role_id = $request->role_id;
            $usuario->estado_id = $request->estado_id;

            if ($request->filled('password')) {
                $usuario->password = Hash::make($request->password);
            }

            $usuario->save();

            return response()->json(["message" => "Usuario actualizado con éxito", "status" => true]);
        }

    // 5. Eliminar Usuario
    public function eliminarPorId($id) {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(["message" => "Usuario no encontrado", "status" => false], 404);
        }

        // Protección de seguridad crítica
        if ($usuario->id === Auth::id()) {
            return response()->json([
                "message" => "Seguridad: No puedes eliminar tu propio usuario mientras estás en sesión.", 
                "status" => false
            ], 403);
        }

        $usuario->delete();

        return response()->json(["message" => "Usuario eliminado del sistema", "status" => true]);
    }
}