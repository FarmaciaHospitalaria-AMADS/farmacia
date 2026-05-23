@extends('layouts.app')
@section('title', 'Historial de Consumo')
@section('content')
<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Historial de Consumo</h2>
            <p class="text-muted small mb-0">Registro de salidas y consumo de insumos.</p>
        </div>
        <a href="{{ route('reportes.consumo.pdf', request()->query()) }}" class="btn btn-dark">
            <i class='bx bxs-file-pdf'></i> Descargar PDF
        </a>
    </div>

    @if(session('error'))
    <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
        <i class='bx bx-error-circle'></i> {{ session('error') }}
    </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reportes.consumo') }}" class="d-flex flex-wrap align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <label class="small fw-semibold text-muted mb-0">Desde</label>
                    <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="form-control form-control-sm">
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label class="small fw-semibold text-muted mb-0">Hasta</label>
                    <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="form-control form-control-sm">
                </div>
                <button type="submit" class="btn btn-dark btn-sm"><i class='bx bx-filter-alt'></i> Filtrar</button>
                <a href="{{ route('reportes.consumo') }}" class="btn btn-light btn-sm"><i class='bx bx-x'></i> Limpiar</a>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-uppercase small fw-black">Fecha</th>
                        <th class="text-uppercase small fw-black">Insumo</th>
                        <th class="text-uppercase small fw-black">Lote</th>
                        <th class="text-uppercase small fw-black">Cantidad</th>
                        <th class="text-uppercase small fw-black">Motivo</th>
                        <th class="text-uppercase small fw-black">Registrado por</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movimientos as $movimiento)
                    <tr>
                        <td class="text-muted small">{{ \Carbon\Carbon::parse($movimiento->fecha)->format('d/m/Y H:i') }}</td>
                        <td class="fw-bold">{{ $movimiento->lote->insumo->nombre ?? 'N/A' }}</td>
                        <td class="font-monospace small text-muted">{{ $movimiento->lote->codigo_lote ?? 'N/A' }}</td>
                        <td class="fw-bold">{{ $movimiento->cantidad }}</td>
                        <td>
                            @if($movimiento->motivo === 'consumo paciente')
                            <span class="badge rounded-pill bg-danger">Consumo Paciente</span>
                            @elseif($movimiento->motivo === 'ajuste')
                            <span class="badge rounded-pill bg-warning text-dark">Ajuste</span>
                            @elseif($movimiento->motivo === 'devolucion')
                            <span class="badge rounded-pill bg-success">Devolución</span>
                            @else
                            <span class="text-muted">{{ $movimiento->motivo ?? 'N/A' }}</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $movimiento->usuario->name ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class='bx bx-history d-block mb-2' style="font-size:2.5rem"></i>
                            No hay registros de consumo.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted small bg-white">
            Mostrando <strong>{{ $movimientos->count() }}</strong> registros
        </div>
    </div>
</div>
@endsection