<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Insumo;
use App\Models\Lote;
use Carbon\Carbon;

class AlertaController extends Controller
{
    // Genera alertas automáticamente revisando insumos y lotes
    public function generarAlertas()
    {
        // 1. Alertas de stock mínimo
        $insumos = Insumo::with('lotes')->get();

        foreach ($insumos as $insumo) {
            $stockTotal = $insumo->lotes->sum('cantidad_actual');

            if ($stockTotal <= $insumo->stock_minimo) {
                $existe = Alerta::where('insumo_id', $insumo->id)
                    ->where('tipo', 'stock_bajo')
                    ->where(function ($q) {
                        $q->where('leida', false)
                            ->orWhere('updated_at', '>=', Carbon::now()->subHours(24));
                    })
                    ->exists();

                if (!$existe) {
                    Alerta::create([
                        'insumo_id' => $insumo->id,
                        'tipo'      => 'stock_bajo',
                        'mensaje'   => "El insumo '{$insumo->nombre}' tiene stock bajo. Stock actual: {$stockTotal}, mínimo: {$insumo->stock_minimo}.",
                        'leida'     => false,
                    ]);
                }
            }
        }

        // 2. Alertas de medicamentos por vencer (próximos 30 días)
        $lotesPorVencer = Lote::with('insumo')
            ->where('cantidad_actual', '>', 0)
            ->whereDate('fecha_vencimiento', '<=', Carbon::now()->addDays(30))
            ->whereDate('fecha_vencimiento', '>=', Carbon::now())
            ->get();

        foreach ($lotesPorVencer as $lote) {
            $existe = Alerta::where('insumo_id', $lote->insumo_id)
                ->where('tipo', 'por_vencer')
                ->where(function ($q) {
                    $q->where('leida', false)
                        ->orWhere('updated_at', '>=', Carbon::now()->subHours(24));
                })
                ->exists();

            if (!$existe) {
                Alerta::create([
                    'insumo_id' => $lote->insumo_id,
                    'tipo'      => 'por_vencer',
                    'mensaje'   => "El lote '{$lote->codigo_lote}' del insumo '{$lote->insumo->nombre}' vence el {$lote->fecha_vencimiento}.",
                    'leida'     => false,
                ]);
            }
        }
    }

    // Vista principal de alertas
    public function index()
    {
        $this->generarAlertas();

        $alertas = Alerta::with('insumo')
            ->where('leida', false)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalStockBajo = $alertas->where('tipo', 'stock_bajo')->count();
        $totalPorVencer = $alertas->where('tipo', 'por_vencer')->count();

        return view('alertas.index', compact('alertas', 'totalStockBajo', 'totalPorVencer'));
    }

    // Marcar alerta como leída
    public function marcarLeida($id)
    {
        $alerta = Alerta::findOrFail($id);
        $alerta->update(['leida' => true]);

        return redirect()->route('alertas.index')->with('success', 'Alerta marcada como leída.');
    }

    // Marcar todas como leídas
    public function marcarTodasLeidas()
    {
        Alerta::where('leida', false)->update(['leida' => true]);

        return redirect()->route('alertas.index')->with('success', 'Todas las alertas fueron marcadas como leídas.');
    }
}
