<?php

use App\Http\Controllers\AlertaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Proveedor;
use App\Models\Insumo;
use App\Models\Alerta;


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
    Route::middleware('role:1')->prefix('admin')->group(function () {
        
        Route::get('/dashboard', function () {
            $totalUsuarios = \App\Models\User::count();
            $totalProveedores = \App\Models\Proveedor::count();
            $totalInsumos = \App\Models\Insumo::count();
            $totalAlertas = \App\Models\Alerta::count();
            
            return view('admin.index', compact('totalUsuarios', 'totalProveedores', 'totalInsumos', 'totalAlertas'));
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
            $totalInsumos = \App\Models\Insumo::count();
            $totalProveedores = \App\Models\Proveedor::count();
            $stockCritico = 0; 
            $alertasPendientes = 0;

            return view('farmacia.index', compact('totalInsumos', 'totalProveedores', 'stockCritico', 'alertasPendientes'));
        })->name('farmacia.dashboard');
        
    });

    // --------------------------------------------------------
    // ÁREA EXCLUSIVA DE ENFERMERÍA (Rol 3)
    // --------------------------------------------------------
    Route::middleware('role:3')->prefix('enfermeria')->group(function () {
        
        Route::get('/dashboard', function () {
            $hoy = Carbon::today();

            $movimientosHoy = DB::table('movimientos')
                                ->whereDate('created_at', $hoy)
                                ->count();

            $entradasHoy = DB::table('movimientos')
                                ->whereDate('created_at', $hoy)
                                ->where('tipo', 'Entrada')
                                ->count();
                                
            $salidasHoy = DB::table('movimientos')
                                ->whereDate('created_at', $hoy)
                                ->where('tipo', 'Salida')
                                ->count();

            $detalleMovimientos = DB::table('movimientos')
                                    ->select('created_at', 'tipo', 'cantidad', 'motivo', 'referencia')
                                    ->whereDate('created_at', $hoy)
                                    ->orderBy('created_at', 'desc')
                                    ->take(10) 
                                    ->get();

            $totalInsumos = DB::table('insumos')->count();

            return view('enfermeria.index', compact(
                'movimientosHoy', 'entradasHoy', 'salidasHoy', 'detalleMovimientos', 'totalInsumos'
            ));
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
});