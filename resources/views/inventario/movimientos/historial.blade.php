@extends('layouts.app')

@section('title', 'Historial de Movimientos')

@section('content')
<style>

.main-wrapper {
    min-height: 100vh;
    background: linear-gradient(135deg, #eef2f7, #d9e2ec);
    display: flex;
    justify-content: center;
    padding: 30px 15px;
}

.content-box {
    width: 100%;
    max-width: 1100px;
    background: #fff;
    border-radius: 18px;
    padding: 25px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    animation: fadeIn 0.4s ease;
}

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header h3 {
    margin: 0;
    font-weight: 700;
    color: #1e3c72;
}

.header p {
    font-size: 0.85rem;
    color: #6c757d;
    margin: 0;
}

.btn-back {
    text-decoration: none;
    background: #dee2e6;
    padding: 8px 15px;
    border-radius: 8px;
    color: #333;
    transition: 0.3s;
}

.btn-back:hover { background: #ced4da; color: #333; }

/* Filtros */
.filter-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 12px;
    align-items: flex-end;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
    flex: 1;
    min-width: 130px;
}

.filter-group label {
    font-size: 0.72rem;
    font-weight: 600;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.filter-input {
    border: none;
    border-bottom: 2px solid #dee2e6;
    padding: 7px 4px;
    font-size: 0.85rem;
    outline: none;
    background: transparent;
    transition: border-color 0.3s;
    width: 100%;
}

.filter-input:focus { border-color: #2a5298; }

.filter-actions {
    display: flex;
    gap: 8px;
    align-items: flex-end;
    padding-bottom: 2px;
}

.btn-filter {
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: white;
    font-size: 0.82rem;
    cursor: pointer;
    transition: 0.3s;
    white-space: nowrap;
}

.btn-filter:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 15px rgba(42,82,152,0.3);
}

.btn-clear {
    padding: 8px 14px;
    border-radius: 8px;
    background: #f8d7da;
    color: #842029;
    font-size: 0.82rem;
    text-decoration: none;
    white-space: nowrap;
    transition: 0.3s;
}

.btn-clear:hover { background: #f1aeb5; color: #842029; }

.filter-summary {
    font-size: 0.8rem;
    color: #6c757d;
    margin-bottom: 12px;
}

.filter-summary strong { color: #1e3c72; }

/* Tabla */
.table-container { overflow-x: auto; }

.custom-table {
    width: 100%;
    border-collapse: collapse;
}

.custom-table thead {
    background: #1e3c72;
    color: white;
}

.custom-table th {
    padding: 12px;
    font-size: 0.8rem;
    text-transform: uppercase;
    font-weight: 600;
}

.custom-table td {
    padding: 12px;
    border-bottom: 1px solid #f1f1f1;
    font-size: 0.9rem;
}

.custom-table tbody tr:hover {
    background: #f8f9fa;
    transition: 0.2s;
}

/* Badges */
.badge-custom {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-custom.entrada { background: #d1e7dd; color: #0f5132; }
.badge-custom.salida  { background: #f8d7da; color: #842029; }

.empty {
    text-align: center;
    padding: 30px;
    color: #6c757d;
}

.pagination-box {
    margin-top: 15px;
    display: flex;
    justify-content: center;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to   { opacity: 1; transform: translateY(0); }
}

</style>

<div class="main-wrapper">
<div class="content-box">

    {{-- HEADER --}}
    <div class="header">
        <div>
            <h3><i class="bi bi-clock-history me-2"></i>Historial de Movimientos</h3>
            <p>Registro detallado de entradas y salidas de inventario</p>
        </div>
        <a href="{{ route('inventario.lotes.index') }}" class="btn-back">← Volver</a>
    </div>

    {{-- FILTROS --}}
    <form method="GET" action="{{ route('inventario.movimientos.historial') }}" class="filter-bar">

        {{-- Búsqueda por código de lote --}}
        <div class="filter-group">
            <label>Código de Lote</label>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="LOTE-2026-001"
                class="filter-input"
            >
        </div>

        {{-- Por insumo --}}
        <div class="filter-group">
            <label>Insumo</label>
            <select name="insumo_id" class="filter-input">
                <option value="">Todos</option>
                @foreach($insumos as $insumo)
                    <option value="{{ $insumo->id }}" {{ request('insumo_id') == $insumo->id ? 'selected' : '' }}>
                        {{ $insumo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Por tipo --}}
        <div class="filter-group">
            <label>Tipo</label>
            <select name="tipo" class="filter-input">
                <option value="">Todos</option>
                <option value="entrada" {{ request('tipo') === 'entrada' ? 'selected' : '' }}>Entrada</option>
                <option value="salida"  {{ request('tipo') === 'salida'  ? 'selected' : '' }}>Salida</option>
            </select>
        </div>

        {{-- Fecha desde --}}
        <div class="filter-group">
            <label>Desde</label>
            <input
                type="date"
                name="fecha_desde"
                value="{{ request('fecha_desde') }}"
                class="filter-input"
            >
        </div>

        {{-- Fecha hasta --}}
        <div class="filter-group">
            <label>Hasta</label>
            <input
                type="date"
                name="fecha_hasta"
                value="{{ request('fecha_hasta') }}"
                class="filter-input"
            >
        </div>

        {{-- Botones --}}
        <div class="filter-actions">
            <button type="submit" class="btn-filter">
                <i class="fa-solid fa-magnifying-glass"></i> Filtrar
            </button>
            @if(request()->hasAny(['search', 'tipo', 'insumo_id', 'fecha_desde', 'fecha_hasta']))
                <a href="{{ route('inventario.movimientos.historial') }}" class="btn-clear">
                    <i class="fa-sharp fa-light fa-filter-circle-xmark"></i>
                </a>
            @endif
        </div>

    </form>

    {{-- Resumen --}}
    @if(request()->hasAny(['search', 'tipo', 'insumo_id', 'fecha_desde', 'fecha_hasta']))
        <p class="filter-summary">
            Mostrando <strong>{{ $movimientos->total() }}</strong> resultado(s) con los filtros aplicados.
        </p>
    @endif

    {{-- TABLA --}}
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Lote</th>
                    <th>Insumo</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Motivo</th>
                    <th>Referencia</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movimientos as $mov)
                <tr>
                    <td>{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $mov->lote->codigo_lote ?? 'N/A' }}</td>
                    <td>{{ $mov->lote->insumo->nombre ?? 'N/A' }}</td>
                    <td>
                        <span class="badge-custom {{ $mov->tipo }}">
                            {{ ucfirst($mov->tipo) }}
                        </span>
                    </td>
                    <td class="fw-bold">{{ $mov->cantidad }}</td>
                    <td>{{ $mov->motivo ?? '-' }}</td>
                    <td>{{ $mov->referencia ?? '-' }}</td>
                    <td>{{ $mov->usuario->name ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="empty"><i class="fa-regular fa-mailbox-open-letter"></i> No hay movimientos con los filtros aplicados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-box">
        {{ $movimientos->links() }}
    </div>

</div>
</div>

@endsection