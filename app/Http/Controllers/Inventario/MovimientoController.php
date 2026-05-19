<?php

namespace App\Http\Controllers\Inventario;

use App\Models\Lote;
use App\Models\Movimiento;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreMovimientoRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class MovimientoController extends Controller implements HasMiddleware
{
 
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    // Formulario ENTRADA — solo Admin (1) y Farmacéutico (2)
    public function entrada(Lote $lote)
    {
        if (!in_array(Auth::user()->role_id, [1, 2])) {
            abort(403, 'No tienes permiso para registrar entradas.');
        }

        return view('inventario.movimientos.entrada', compact('lote'));
    }

    // Formulario SALIDA — Admin (1), Farmacéutico (2) y Enfermería (3)
    public function salida(Lote $lote)
    {
        if (!in_array(Auth::user()->role_id, [1, 2, 3])) {
            abort(403, 'No tienes permiso para registrar salidas.');
        }

        return view('inventario.movimientos.salida', compact('lote'));
    }

    public function store(StoreMovimientoRequest $request, Lote $lote)
    {
        $tipo     = $request->tipo;
        $cantidad = $request->cantidad;

        if ($tipo === 'entrada' && !in_array(Auth::user()->role_id, [1, 2])) {
            abort(403, 'No tienes permiso para registrar entradas.');
        }

        if ($tipo === 'salida') {
            if (!$lote->tieneStock($cantidad)) {
                return back()
                    ->withErrors(['cantidad' => 'Stock insuficiente en este lote.'])
                    ->withInput();
            }
            if ($lote->estaVencido()) {
                return back()
                    ->withErrors(['lote' => 'No se puede consumir un lote vencido.'])
                    ->withInput();
            }
        }

        DB::transaction(function () use ($request, $lote, $tipo, $cantidad) {
            Movimiento::create([
                'lote_id'    => $lote->id,
                'tipo'       => $tipo,
                'cantidad'   => $cantidad,
                'motivo'     => $request->motivo,
                'referencia' => $request->referencia,
                'usuario_id' => Auth::id(),
            ]);

            if ($tipo === 'entrada') {
                $lote->increment('cantidad_actual', $cantidad);
            } else {
                $lote->decrement('cantidad_actual', $cantidad);
            }

            if ($lote->fresh()->cantidad_actual <= 0) {
                $lote->update(['estado' => 'agotado']);
            }
        });

        return redirect()->route('inventario.lotes.show', $lote)
            ->with('success', 'Movimiento registrado correctamente.');
    }

    // Historial — todos los roles
    public function historial()
    {
        $movimientos = Movimiento::with(['lote.insumo', 'usuario'])
            ->latest()
            ->paginate(20);

        return view('inventario.movimientos.historial', compact('movimientos'));
    }
}