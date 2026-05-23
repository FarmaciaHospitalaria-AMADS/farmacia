<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\Inventario\LoteController;
use App\Http\Controllers\Inventario\MovimientoController;
use Illuminate\Support\Facades\DB;
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
            // Contamos los registros reales en la base de datos
            $totalUsuarios = \App\Models\User::count();
            $totalProveedores = \App\Models\Proveedor::count();
            $totalInsumos = \App\Models\Insumo::count();
            
            $totalAlertas = \Illuminate\Support\Facades\DB::table('alertas')
                                ->where('leida', 0)
                                ->count();

            $alertasRecientes = \Illuminate\Support\Facades\DB::table('alertas')
                                ->where('leida', 0)
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

            return view('admin.index', compact('totalUsuarios', 'totalProveedores', 'totalInsumos', 'totalAlertas', 'alertasRecientes'));
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
            // Contamos los registros reales
            $totalInsumos = \App\Models\Insumo::count();
            $totalProveedores = \App\Models\Proveedor::count();
            
            // 1. Contamos SOLO las alertas NO leídas (leida = 0)
            $alertasPendientes = \Illuminate\Support\Facades\DB::table('alertas')
                                ->where('leida', 0)
                                ->count();
                                
            // 2. Extra: Filtramos cuántas de esas alertas son de "stock crítico"
            $stockCritico = \Illuminate\Support\Facades\DB::table('alertas')
                                ->where('leida', 0)
                                ->where('tipo', 'stock_bajo')
                                ->count();

            // 3. Traemos las últimas 5 alertas NO leídas para la lista lateral
            $alertasRecientes = \Illuminate\Support\Facades\DB::table('alertas')
                                ->where('leida', 0)
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

            return view('farmacia.index', compact('totalInsumos', 'totalProveedores', 'stockCritico', 'alertasPendientes', 'alertasRecientes'));
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

    // --------------------------------------------------------
    // MÓDULO DE REPORTES (Admin y Farmacéutico)
    // --------------------------------------------------------
    Route::middleware('role:1,2')->prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/stock', [ReporteController::class, 'stock'])->name('stock');
        Route::get('/stock/pdf', [ReporteController::class, 'stockPdf'])->name('stock.pdf');
        Route::get('/consumo', [ReporteController::class, 'consumo'])->name('consumo');
        Route::get('/consumo/pdf', [ReporteController::class, 'consumoPdf'])->name('consumo.pdf');
        Route::get('/ingresos', [ReporteController::class, 'ingresos'])->name('ingresos');
        Route::get('/ingresos/pdf', [ReporteController::class, 'ingresosPdf'])->name('ingresos.pdf');
    });

    // --------------------------------------------------------
    // INVENTARIO (Lotes y Movimientos)
    // --------------------------------------------------------
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

        Route::get('/admin/proveedores', function () {
        return view('farmacia.proveedores');
    });

    Route::get('/admin/insumos', function () {
        return view('farmacia.insumos'); 
    })->name('insumos.index');
    
    Route::middleware(['auth', 'role:1'])->group(function () {
        Route::get('/admin/configuraciones', function () {
            return view('admin.configuraciones');
        });
    });
});

