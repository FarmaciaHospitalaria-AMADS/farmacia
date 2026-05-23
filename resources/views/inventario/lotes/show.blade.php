@extends('layouts.app')

@section('title', 'Detalle del Lote')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"> Detalle del Lote: {{ $lote->codigo_lote }}</h2>
        <a href="{{ route('inventario.lotes.index') }}" class="btn btn-secondary">← Volver</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Info del lote --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">Información del Lote</div>
                <div class="card-body">
                    <p><strong>Código:</strong> {{ $lote->codigo_lote }}</p>
                    <p><strong>Insumo:</strong> {{ $lote->insumo->nombre ?? 'N/A' }}</p>
                    <p><strong>Ubicación:</strong> {{ $lote->ubicacion->nombre ?? 'No especificada' }}</p>  
                    <p><strong>Proveedor:</strong> {{ $lote->proveedor ?? 'No especificado' }}</p>
                    <p><strong>Fecha Entrada:</strong> {{ $lote->fecha_entrada->format('d/m/Y') }}</p>
                    <p><strong>Fecha Vencimiento:</strong>
                        <span class="{{ $lote->estaVencido() ? 'text-danger fw-bold' : 'text-success' }}">
                            {{ $lote->fecha_vencimiento->format('d/m/Y') }}
                            @if($lote->estaVencido()) ⚠️ VENCIDO @endif
                        </span>
                    </p>
                    <p><strong>Registrado por:</strong> {{ $lote->registrador->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">Stock</div>
                <div class="card-body text-center">
                    <h1 class="display-4 fw-bold {{ $lote->cantidad_actual <= 0 ? 'text-danger' : 'text-success' }}">
                        {{ $lote->cantidad_actual }}
                    </h1>
                    <p class="text-muted">unidades disponibles</p>
                    <p>Cantidad inicial: <strong>{{ $lote->cantidad_inicial }}</strong></p>

                    @php
                        $badge = match($lote->estado) {
                            'activo'  => 'success',
                            'agotado' => 'danger',
                            'vencido' => 'warning',
                            default   => 'secondary',
                        };
                    @endphp
                    <span class="badge bg-{{ $badge }} fs-6">{{ ucfirst($lote->estado) }}</span>

                    <div class="mt-3 d-flex gap-2 justify-content-center">
                        @if(in_array(auth()->user()->role_id, [1, 2]))
                            <a href="{{ route('inventario.movimientos.entrada', $lote) }}"
                               class="btn btn-success">+ Entrada</a>
                        @endif
                        <a href="{{ route('inventario.movimientos.salida', $lote) }}"
                           class="btn btn-warning">- Salida</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Historial de movimientos --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Historial de Movimientos
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Motivo</th>
                        <th>Referencia</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lote->movimientos as $mov)
                    <tr>
                        <td>{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="badge bg-{{ $mov->tipo === 'entrada' ? 'success' : 'danger' }}">
                                {{ ucfirst($mov->tipo) }}
                            </span>
                        </td>
                        <td>{{ $mov->cantidad }}</td>
                        <td>{{ $mov->motivo ?? '-' }}</td>
                        <td>{{ $mov->referencia ?? '-' }}</td>
                        <td>{{ $mov->usuario->name ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Sin movimientos registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection