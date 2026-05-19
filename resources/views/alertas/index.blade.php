@extends('layouts.app')
@section('title', 'Alertas del Sistema')
@section('content')
<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Alertas del Sistema</h2>
            <p class="text-muted small mb-0">Monitoreo de stock bajo y medicamentos por vencer.</p>
        </div>
        @if($alertas->count() > 0)
        <form action="{{ route('alertas.todasLeidas') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-dark">
                <i class='bx bx-check-double'></i> Marcar todas como leídas
            </button>
        </form>
        @endif
    </div>

    @if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2">
        <i class='bx bx-check-circle'></i> {{ session('success') }}
    </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-warning bg-opacity-10 text-warning fs-4"><i class='bx bx-error'></i></div>
                    <div>
                        <h3 class="fw-black mb-0">{{ $totalStockBajo }}</h3>
                        <p class="text-muted small mb-0">Stock Bajo</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-danger bg-opacity-10 text-danger fs-4"><i class='bx bx-calendar-x'></i></div>
                    <div>
                        <h3 class="fw-black mb-0">{{ $totalPorVencer }}</h3>
                        <p class="text-muted small mb-0">Por Vencer</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary fs-4"><i class='bx bx-bell'></i></div>
                    <div>
                        <h3 class="fw-black mb-0">{{ $alertas->count() }}</h3>
                        <p class="text-muted small mb-0">Total Pendientes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-uppercase small fw-black">Tipo</th>
                        <th class="text-uppercase small fw-black">Insumo</th>
                        <th class="text-uppercase small fw-black">Mensaje</th>
                        <th class="text-uppercase small fw-black">Fecha</th>
                        <th class="text-uppercase small fw-black text-end">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alertas as $alerta)
                    <tr>
                        <td>
                            @if($alerta->tipo === 'stock_bajo')
                                <span class="badge rounded-pill bg-warning text-dark"><i class='bx bxs-circle me-1' style="font-size:0.5rem"></i> Stock Bajo</span>
                            @else
                                <span class="badge rounded-pill bg-danger"><i class='bx bxs-circle me-1' style="font-size:0.5rem"></i> Por Vencer</span>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $alerta->insumo->nombre ?? 'N/A' }}</td>
                        <td class="text-muted">{{ $alerta->mensaje }}</td>
                        <td class="text-muted small">{{ $alerta->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <form action="{{ route('alertas.leida', $alerta->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-light" title="Marcar como leída">
                                    <i class='bx bx-check'></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class='bx bx-check-shield d-block mb-2' style="font-size:2.5rem"></i>
                            No hay alertas pendientes.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted small bg-white">
            Mostrando <strong>{{ $alertas->count() }}</strong> alertas pendientes
        </div>
    </div>
</div>
@endsection