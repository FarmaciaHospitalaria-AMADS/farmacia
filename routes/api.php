<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\InsumoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/proveedores/obtener/todos', [ProveedorController::class, 'obtenerTodos']);
Route::post('/proveedores/crear', [ProveedorController::class, 'crear']);
Route::put('/proveedores/actualizar', [ProveedorController::class, 'actualizarPorId']);
Route::delete('/proveedores/eliminar/{id}', [ProveedorController::class, 'eliminarPorId']);
Route::get('/insumos/obtener/todos', [InsumoController::class, 'obtenerTodos']);
Route::post('/insumos/crear', [InsumoController::class, 'crear']);
Route::put('/insumos/actualizar', [InsumoController::class, 'actualizarPorId']);
Route::delete('/insumos/eliminar/{id}', [InsumoController::class, 'eliminarPorId']);Route::get('/insumos/obtener/todos', [InsumoController::class, 'obtenerTodos']);
Route::post('/insumos/crear', [InsumoController::class, 'crear']);
Route::put('/insumos/actualizar', [InsumoController::class, 'actualizarPorId']);
Route::delete('/insumos/eliminar/{id}', [InsumoController::class, 'eliminarPorId']);
Route::get('/insumos/buscar/{termino}', [InsumoController::class, 'buscar']);