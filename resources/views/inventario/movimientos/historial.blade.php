@extends('layouts.app')

@section('title', 'Historial de Movimientos')

@section('content')
<div class="main-wrapper">

    <div class="content-box">

        <!-- Header -->
        <div class="header">
            <div>
                <h3><i class="bi bi-clock-history me-2"></i>Historial de Movimientos</h3>
                <p>Registro detallado de entradas y salidas de inventario</p>
            </div>

            <a href="{{ route('inventario.lotes.index') }}" class="btn-back">
                ← Volver
            </a>
        </div>

        <!-- Tabla -->
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
                        <td colspan="8" class="empty">
                            No hay movimientos registrados 📭
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="pagination-box">
            {{ $movimientos->links() }}
        </div>

    </div>

</div>

<style>

/* Fondo */
.main-wrapper {
    min-height: 100vh;
    background: linear-gradient(135deg, #eef2f7, #d9e2ec);
    display: flex;
    justify-content: center;
    padding: 30px 15px;
}

/* Contenedor */
.content-box {
    width: 100%;
    max-width: 1100px;
    background: #fff;
    border-radius: 18px;
    padding: 25px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
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

/* Botón volver */
.btn-back {
    text-decoration: none;
    background: #dee2e6;
    padding: 8px 15px;
    border-radius: 8px;
    color: #333;
    transition: 0.3s;
}

.btn-back:hover {
    background: #ced4da;
}

/* Tabla */
.table-container {
    overflow-x: auto;
}

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
    font-size: 0.85rem;
    text-transform: uppercase;
}

.custom-table td {
    padding: 12px;
    border-bottom: 1px solid #f1f1f1;
    font-size: 0.9rem;
}

/* Hover elegante */
.custom-table tbody tr:hover {
    background: #f8f9fa;
    transition: 0.2s;
}

/* Badges */
.badge-custom {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

/* Entrada */
.badge-custom.entrada {
    background: #d1e7dd;
    color: #0f5132;
}

/* Salida */
.badge-custom.salida {
    background: #f8d7da;
    color: #842029;
}

/* Empty */
.empty {
    text-align: center;
    padding: 30px;
    color: #6c757d;
}

/* Paginación */
.pagination-box {
    margin-top: 15px;
    display: flex;
    justify-content: center;
}

</style>
@endsection