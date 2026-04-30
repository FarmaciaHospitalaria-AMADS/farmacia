<?php

use App\Http\Controllers\AlertaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Rutas para usuarios NO autenticados (guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rutas para usuarios SÍ autenticados (auth)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:1')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.index');
        })->name('admin.dashboard');
    });

    // Panel de Farmacia (Solo role_id: 2)
    Route::middleware('role:2')->prefix('farmacia')->group(function () {
        Route::get('/dashboard', function () {
            return view('farmacia.index');
        })->name('farmacia.dashboard');
    });

    // Panel de Enfermería (Solo role_id: 3)
    Route::middleware('role:3')->prefix('enfermeria')->group(function () {
        Route::get('/dashboard', function () {
            return view('enfermeria.index');
        })->name('enfermeria.dashboard');
    });

    // Alertas (Admin y Farmacéutico)
    Route::middleware('role:1,2')->prefix('alertas')->group(function () {
        Route::get('/', [AlertaController::class, 'index'])->name('alertas.index');
        Route::post('/{id}/leida', [AlertaController::class, 'marcarLeida'])->name('alertas.leida');
        Route::post('/todas-leidas', [AlertaController::class, 'marcarTodasLeidas'])->name('alertas.todasLeidas');
    });
});
