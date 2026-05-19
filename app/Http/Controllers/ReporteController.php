<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\Lote;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    // Reporte de stock actual
    public function stock()
    {
        $insumos = Insumo::with(['lotes' => function ($query) {
            $query->where('estado', 'activo');
        }, 'categoria', 'proveedor'])->get();

        $insumos = $insumos->map(function ($insumo) {
            $insumo->stock_total = $insumo->lotes->sum('cantidad_actual');
            return $insumo;
        });

        return view('reportes.stock', compact('insumos'));
    }

    public function stockPdf()
    {
        $insumos = Insumo::with(['lotes' => function ($query) {
            $query->where('estado', 'activo');
        }, 'categoria', 'proveedor'])->get();

        $insumos = $insumos->map(function ($insumo) {
            $insumo->stock_total = $insumo->lotes->sum('cantidad_actual');
            return $insumo;
        });

        $pdf = Pdf::loadView('reportes.pdf.stock', compact('insumos'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('reporte-stock-' . now()->format('Y-m-d') . '.pdf');
    }

    // Reporte de historial de consumo
    public function consumo(Request $request)
    {
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            if ($request->fecha_fin < $request->fecha_inicio) {
                return redirect()->route('reportes.consumo')
                    ->with('error', 'La fecha fin no puede ser menor a la fecha inicio.');
            }
        }

        $query = Movimiento::with(['lote.insumo', 'usuario'])
            ->where('tipo', 'salida')
            ->orderBy('fecha', 'desc');

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha', [
                $request->fecha_inicio . ' 00:00:00',
                $request->fecha_fin . ' 23:59:59'
            ]);
        }

        $movimientos = $query->get();

        return view('reportes.consumo', compact('movimientos'));
    }

    public function consumoPdf(Request $request)
    {
        $query = Movimiento::with(['lote.insumo', 'usuario'])
            ->where('tipo', 'salida')
            ->orderBy('fecha', 'desc');

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha', [
                $request->fecha_inicio . ' 00:00:00',
                $request->fecha_fin . ' 23:59:59'
            ]);
        }

        $movimientos = $query->get();

        $pdf = Pdf::loadView('reportes.pdf.consumo', compact('movimientos'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('reporte-consumo-' . now()->format('Y-m-d') . '.pdf');
    }

    // Reporte de ingresos de suministros
    public function ingresos(Request $request)
    {
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            if ($request->fecha_fin < $request->fecha_inicio) {
                return redirect()->route('reportes.consumo')
                    ->with('error', 'La fecha fin no puede ser menor a la fecha inicio.');
            }
        }
        
        $query = Movimiento::with(['lote.insumo', 'usuario'])
            ->where('tipo', 'entrada')
            ->orderBy('fecha', 'desc');

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha', [
                $request->fecha_inicio . ' 00:00:00',
                $request->fecha_fin . ' 23:59:59'
            ]);
        }

        $movimientos = $query->get();

        return view('reportes.ingresos', compact('movimientos'));
    }

    public function ingresosPdf(Request $request)
    {
        $query = Movimiento::with(['lote.insumo', 'usuario'])
            ->where('tipo', 'entrada')
            ->orderBy('fecha', 'desc');

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha', [
                $request->fecha_inicio . ' 00:00:00',
                $request->fecha_fin . ' 23:59:59'
            ]);
        }

        $movimientos = $query->get();

        $pdf = Pdf::loadView('reportes.pdf.ingresos', compact('movimientos'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('reporte-ingresos-' . now()->format('Y-m-d') . '.pdf');
    }
}
