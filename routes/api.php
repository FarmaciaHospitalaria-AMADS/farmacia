<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// rutas para proveedores
Route::get('/proveedores/obtener/todos', [ProveedorController::class, 'obtenerTodos']);
Route::post('/proveedores/crear', [ProveedorController::class, 'crear']);
Route::put('/proveedores/actualizar', [ProveedorController::class, 'actualizarPorId']);
Route::delete('/proveedores/eliminar/{id}', [ProveedorController::class, 'eliminarPorId']);
Route::get('/proveedores', [ProveedorController::class, 'index']);

// rutas para insumos
Route::get('/insumos/obtener/todos', [InsumoController::class, 'obtenerTodos']);
Route::post('/insumos/crear', [InsumoController::class, 'crear']);
Route::put('/insumos/actualizar', [InsumoController::class, 'actualizarPorId']);
Route::delete('/insumos/eliminar/{id}', [InsumoController::class, 'eliminarPorId']);
Route::get('/insumos/buscar/{termino}', [InsumoController::class, 'buscar']);
Route::get('/insumos', [InsumoController::class, 'index']);

// rutas para categorias
Route::get('/categorias/obtener/todos', [CategoriaController::class, 'obtenerTodos']);
Route::get('/categorias/obtener/{id}', [CategoriaController::class, 'obtenerPorId']);
Route::post('/categorias/crear', [CategoriaController::class, 'crear']);
Route::put('/categorias/actualizar', [CategoriaController::class, 'actualizarPorId']);
Route::delete('/categorias/eliminar/{id}', [CategoriaController::class, 'eliminarPorId']);
Route::get('/categorias/buscar/{termino}', [CategoriaController::class, 'buscar']);

// rutas para areas
Route::get('/areas/obtener/todos', [AreaController::class, 'obtenerTodos']);
Route::get('/areas/obtener/{id}', [AreaController::class, 'obtenerPorId']);
Route::post('/areas/crear', [AreaController::class, 'crear']);
Route::put('/areas/actualizar', [AreaController::class, 'actualizarPorId']);
Route::delete('/areas/eliminar/{id}', [AreaController::class, 'eliminarPorId']);
Route::get('/areas/buscar/{termino}', [AreaController::class, 'buscar']);

// rutas para ubicaciones
Route::get('/ubicaciones/obtener/todos', [UbicacionController::class, 'obtenerTodos']);
Route::get('/ubicaciones/obtener/{id}', [UbicacionController::class, 'obtenerPorId']);
Route::post('/ubicaciones/crear', [UbicacionController::class, 'crear']);
Route::put('/ubicaciones/actualizar', [UbicacionController::class, 'actualizarPorId']);
Route::delete('/ubicaciones/eliminar/{id}', [UbicacionController::class, 'eliminarPorId']);
Route::get('/ubicaciones/buscar/{termino}', [UbicacionController::class, 'buscar']);

// rutas para estados
Route::get('/estados/obtener/todos', [EstadoController::class, 'obtenerTodos']);
Route::get('/estados/obtener/{id}', [EstadoController::class, 'obtenerPorId']);
Route::post('/estados/crear', [EstadoController::class, 'crear']);
Route::put('/estados/actualizar', [EstadoController::class, 'actualizarPorId']);
Route::delete('/estados/eliminar/{id}', [EstadoController::class, 'eliminarPorId']);
Route::get('/estados/buscar/{termino}', [EstadoController::class, 'buscar']);

// Rutas para Gestión de Usuarios
Route::get('/usuarios', [UserController::class, 'index']);
Route::get('/roles/obtener/todos', [UserController::class, 'obtenerRoles']);
Route::post('/usuarios/crear', [UserController::class, 'crear']);
Route::put('/usuarios/actualizar', [UserController::class, 'actualizarPorId']);
Route::delete('/usuarios/eliminar/{id}', [UserController::class, 'eliminarPorId']);