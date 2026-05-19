@extends('layouts.app')

@section('title', 'Inventario de Lotes')

@section('content')

<style>

/* Fondo */
.main-wrapper {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    background: linear-gradient(135deg, #eef2f7, #d9e2ec);
    padding: 30px 15px;
}

/* Card principal */
.container-card {
    width: 100%;
    max-width: 1000px;
    background: white;
    border-radius: 20px;
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
    font-weight: 700;
    color: #1e3c72;
    margin: 0;
}

.header p {
    font-size: 0.9rem;
    color: #6c757d;
    margin: 0;
}

/* Botón principal */
.btn-main {
    border: none;
    padding: 8px 15px;
    border-radius: 8px;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: white;
    font-size: 0.85rem;
    cursor: pointer;
    text-decoration: none;
    transition: 0.3s;
}

.btn-main:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(42,82,152,0.3);
    color: white;
}

/* ── FILTROS ── */
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
    min-width: 140px;
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

.filter-input:focus {
    border-color: #2a5298;
}

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

.btn-clear:hover {
    background: #f1aeb5;
    color: #842029;
}

/* Resultados activos */
.filter-summary {
    font-size: 0.8rem;
    color: #6c757d;
    margin-bottom: 12px;
}

.filter-summary strong {
    color: #1e3c72;
}

/* Tabla */
.table-custom {
    width: 100%;
    border-collapse: collapse;
}

.table-custom th {
    font-size: 0.75rem;
    text-transform: uppercase;
    color: #6c757d;
    border-bottom: 1px solid #dee2e6;
    padding: 10px;
}

.table-custom td {
    padding: 10px;
    font-size: 0.9rem;
    border-bottom: 1px solid #f1f1f1;
}

.table-custom tr:hover {
    background: #f8f9fa;
}

/* Código */
.code {
    background: #f1f5f9;
    padding: 3px 8px;
    border-radius: 6px;
    font-family: monospace;
}

/* Badge */
.badge-soft {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.success { background:#d1e7dd; color:#0f5132; }
.danger  { background:#f8d7da; color:#842029; }
.warning { background:#fff3cd; color:#664d03; }

/* Acciones */
.actions a {
    margin: 0 2px;
    padding: 5px 8px;
    border-radius: 6px;
    background: #f1f1f1;
    font-size: 0.8rem;
    text-decoration: none;
}

.actions a:hover {
    background: #e2e6ea;
}

/* Empty */
.empty {
    text-align: center;
    padding: 40px;
    color: #6c757d;
}

/* Animación */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to   { opacity: 1; transform: translateY(0); }
}

</style>

<div class="main-wrapper">
<div class="container-card">

    {{-- HEADER --}}
    <div class="header">
        <div>
            <h3>Inventario de Lotes</h3>
            <p>Gestión y control de stock</p>
        </div>
        @if(in_array(auth()->user()->role_id, [1, 2]))
            <a href="{{ route('inventario.lotes.create') }}" class="btn-main">
                <i class="fa-solid fa-plus"></i> Nuevo Lote
            </a>
        @endif
    </div>

    {{-- FILTROS --}}
    <form method="GET" action="{{ route('inventario.lotes.index') }}" class="filter-bar">

        {{-- Búsqueda por código --}}
        <div class="filter-group">
            <label>Código</label>
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

        {{-- Por estado --}}
        <div class="filter-group">
            <label>Estado</label>
            <select name="estado" class="filter-input">
                <option value="">Todos</option>
                <option value="activo"  {{ request('estado') === 'activo'  ? 'selected' : '' }}>Activo</option>
                <option value="agotado" {{ request('estado') === 'agotado' ? 'selected' : '' }}>Agotado</option>
                <option value="vencido" {{ request('estado') === 'vencido' ? 'selected' : '' }}>Vencido</option>
            </select>
        </div>

        {{-- Por vencimiento --}}
        <div class="filter-group">
            <label>Vencimiento</label>
            <select name="vencimiento" class="filter-input">
                <option value="">Cualquiera</option>
                <option value="vigente" {{ request('vencimiento') === 'vigente' ? 'selected' : '' }}>Vigentes</option>
                <option value="proximo" {{ request('vencimiento') === 'proximo' ? 'selected' : '' }}>Próximos 30 días</option>
                <option value="vencido" {{ request('vencimiento') === 'vencido' ? 'selected' : '' }}>Vencidos</option>
            </select>
        </div>

        {{-- Botones --}}
        <div class="filter-actions">
            <button type="submit" class="btn-filter">
                <i class="fa-solid fa-magnifying-glass"></i> Filtrar
            </button>
            @if(request()->hasAny(['search', 'estado', 'insumo_id', 'vencimiento']))
                <a href="{{ route('inventario.lotes.index') }}" class="btn-clear">
                    <i class="fa-sharp fa-light fa-filter-circle-xmark"></i>
                </a>
            @endif
        </div>

    </form>

    {{-- Resumen de resultados --}}
    @if(request()->hasAny(['search', 'estado', 'insumo_id', 'vencimiento']))
        <p class="filter-summary">
            Mostrando <strong>{{ $lotes->total() }}</strong> resultado(s) con los filtros aplicados.
        </p>
    @endif

    {{-- TABLA --}}
    @if($lotes->count() > 0)
    <table class="table-custom">
        <thead>
            <tr>
                <th>Lote</th>
                <th>Insumo</th>
                <th>Stock</th>
                <th>Vencimiento</th>
                <th>Estado</th>
                <th>Usuario</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($lotes as $lote)
            <tr>
                <td><span class="code">{{ $lote->codigo_lote }}</span></td>
                <td>{{ $lote->insumo->nombre ?? 'N/A' }}</td>
                <td><strong>{{ $lote->cantidad_actual }}</strong></td>
                <td>{{ $lote->fecha_vencimiento->format('d/m/Y') }}</td>
                <td>
                    <span class="badge-soft {{ $lote->estado=='activo' ? 'success' : ($lote->estado=='agotado' ? 'danger' : 'warning') }}">
                        {{ ucfirst($lote->estado) }}
                    </span>
                </td>
                <td>{{ $lote->registrador->name ?? 'Sistema' }}</td>
                <td class="actions text-end">
                    <a href="{{ route('inventario.lotes.show', $lote) }}"><i class="fa-solid fa-eye"></i></a>
                    <a href="{{ route('inventario.movimientos.entrada', $lote) }}"><i class="fa-regular fa-plus"></i></a>
                    <a href="{{ route('inventario.movimientos.salida', $lote) }}"><i class="fa-solid fa-minus"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3 text-center">
        {{ $lotes->links() }}
    </div>

    @else
    <div class="empty">
        <i class="fa-graphite fa-thin fa-box"></i> No se encontraron lotes con los filtros aplicados.
    </div>
    @endif

</div>
</div>

@endsection