<?php

namespace App\Http\Controllers\Inventario;

use App\Models\Lote;
use App\Models\Insumo;
use App\Models\Movimiento;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreLoteRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class LoteController extends Controller implements HasMiddleware
{
        public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('role:1,2', except: ['index', 'show']),
        ];
    }

    public function index()
    {
        $lotes = Lote::with(['insumo', 'registrador'])
            ->orderBy('fecha_vencimiento')
            ->paginate(15);

        return view('inventario.lotes.index', compact('lotes'));
    }

    public function create()
    {
        $insumos = Insumo::orderBy('nombre')->get();
        return view('inventario.lotes.create', compact('insumos'));
    }

    public function store(StoreLoteRequest $request)
    {
        DB::transaction(function () use ($request) {
            $lote = Lote::create([
                ...$request->validated(),
                'cantidad_actual' => $request->cantidad_inicial,
                'registrado_por'  => Auth::id(),
                'fecha_entrada'   => now()->toDateString(),
            ]);

            Movimiento::create([
                'lote_id'    => $lote->id,
                'tipo'       => 'entrada',
                'cantidad'   => $request->cantidad_inicial,
                'motivo'     => 'Registro inicial de lote',
                'usuario_id' => Auth::id(),
            ]);
        });

        return redirect()->route('inventario.lotes.index')
            ->with('success', 'Lote registrado correctamente.');
    }

    public function show(Lote $lote)
    {
        $lote->load(['insumo', 'movimientos.usuario', 'registrador']);
        return view('inventario.lotes.show', compact('lote'));
    }
}