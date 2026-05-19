<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\Inventario\LoteController;
use App\Http\Controllers\Inventario\MovimientoController;

// ========================================================
// RUTAS PARA USUARIOS NO AUTENTICADOS (GUEST)
// ========================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// ========================================================
// REDIRECCIÓN RAÍZ DINÁMICA
// ========================================================
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return match ($user->role_id) {
            1 => redirect()->route('admin.dashboard'),
            2 => redirect()->route('farmacia.dashboard'),
            3 => redirect()->route('enfermeria.dashboard'),
            default => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});

// ========================================================
// RUTAS PARA USUARIOS AUTENTICADOS
// ========================================================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --------------------------------------------------------
    // ÁREA EXCLUSIVA DEL ADMINISTRADOR (Rol 1)
    // --------------------------------------------------------
    // Panel de Admin (Solo role_id: 1)
    Route::middleware('role:1')->prefix('admin')->group(function () {
        
        Route::get('/dashboard', function () {
            return view('admin.index');
        })->name('admin.dashboard');

        // Protegido estrictamente solo para el Admin
        Route::get('/usuarios', function () {
            return view('admin.usuarios');
        });

        // Protegido estrictamente solo para el Admin
        Route::get('/configuraciones', function () {
            return view('admin.configuraciones');
        });
    });

    // --------------------------------------------------------
    // RUTA COMPARTIDA: ADMIN Y FARMACIA (Roles 1 y 2)
    // --------------------------------------------------------
    // Asumiendo que ambos necesitan gestionar o ver proveedores e insumos
    Route::middleware('role:1,2')->prefix('admin')->group(function () {
        
        Route::get('/proveedores', function () {
            return view('farmacia.proveedores');
        });

        Route::get('/insumos', function () {
            return view('farmacia.insumos'); 
        })->name('insumos.index');
        
    });

    // --------------------------------------------------------
    // ÁREA EXCLUSIVA DE FARMACIA (Rol 2)
    // --------------------------------------------------------
    Route::middleware('role:2')->prefix('farmacia')->group(function () {
        
        Route::get('/dashboard', function () {
            return view('farmacia.index');
        })->name('farmacia.dashboard');
        
    });

    // --------------------------------------------------------
    // ÁREA EXCLUSIVA DE ENFERMERÍA (Rol 3)
    // --------------------------------------------------------
    Route::middleware('role:3')->prefix('enfermeria')->group(function () {
        
        Route::get('/dashboard', function () {
            return view('enfermeria.index');
        })->name('enfermeria.dashboard');
        
    });

    // --------------------------------------------------------
    // MÓDULO DE ALERTAS (Admin y Farmacéutico)
    // --------------------------------------------------------
    Route::middleware('role:1,2')->prefix('alertas')->group(function () {
        Route::get('/', [AlertaController::class, 'index'])->name('alertas.index');
        Route::post('/{id}/leida', [AlertaController::class, 'marcarLeida'])->name('alertas.leida');
        Route::post('/todas-leidas', [AlertaController::class, 'marcarTodasLeidas'])->name('alertas.todasLeidas');
    });
    // Reportes (Admin y Farmacéutico)
    Route::middleware('role:1,2')->prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/stock', [ReporteController::class, 'stock'])->name('stock');
        Route::get('/stock/pdf', [ReporteController::class, 'stockPdf'])->name('stock.pdf');
        Route::get('/consumo', [ReporteController::class, 'consumo'])->name('consumo');
        Route::get('/consumo/pdf', [ReporteController::class, 'consumoPdf'])->name('consumo.pdf');
        Route::get('/ingresos', [ReporteController::class, 'ingresos'])->name('ingresos');
        Route::get('/ingresos/pdf', [ReporteController::class, 'ingresosPdf'])->name('ingresos.pdf');
    });

    // Rutas de Admin (proveedores, insumos, configuraciones)
    Route::get('/admin/proveedores', function () {
        return view('farmacia.proveedores');
    });

    Route::get('/admin/insumos', function () {
        return view('farmacia.insumos');
    })->name('insumos.index');

    Route::middleware('role:1')->group(function () {
        Route::get('/admin/configuraciones', function () {
            return view('admin.configuraciones');
        });
    });

    // Inventario (lotes y movimientos)
    Route::prefix('inventario')->name('inventario.')->group(function () {

        // LOTES
        Route::resource('lotes', LoteController::class)
            ->only(['index', 'create', 'store', 'show']);

        // MOVIMIENTOS
        Route::get('lotes/{lote}/entrada', [MovimientoController::class, 'entrada'])
            ->name('movimientos.entrada');
        Route::get('lotes/{lote}/salida', [MovimientoController::class, 'salida'])
            ->name('movimientos.salida');
        Route::post('lotes/{lote}/movimiento', [MovimientoController::class, 'store'])
            ->name('movimientos.store');

        // HISTORIAL
        Route::get('historial', [MovimientoController::class, 'historial'])
            ->name('movimientos.historial');
    });
});
