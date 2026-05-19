@extends('layouts.app')

@section('title', 'Inventario de Lotes')

@section('content')

<style>

/* Fondo tipo formulario */
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
    max-width: 900px;
    background: white;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    animation: fadeIn 0.4s ease;
}

/* Header */
.header {
    text-align: center;
    margin-bottom: 20px;
}

.header h3 {
    font-weight: 700;
    color: #1e3c72;
}

.header p {
    font-size: 0.9rem;
    color: #6c757d;
}

/* Botón */
.btn-main {
    border: none;
    padding: 8px 15px;
    border-radius: 8px;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: white;
    font-size: 0.85rem;
    transition: 0.3s;
}

.btn-main:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(42,82,152,0.3);
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
.danger { background:#f8d7da; color:#842029; }
.warning { background:#fff3cd; color:#664d03; }

/* Acciones */
.actions a {
    margin: 0 2px;
    padding: 5px 8px;
    border-radius: 6px;
    background: #f1f1f1;
    font-size: 0.8rem;
}

/* Empty */
.empty {
    text-align: center;
    padding: 30px;
    color: #6c757d;
}

/* Animación */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

</style>

<div class="main-wrapper">
<div class="container-card">

    <!-- HEADER -->
<div class="header d-flex justify-content-between align-items-center">
    <div>
        <h3>Inventario de Lotes</h3>
        <p>Gestión y control de stock</p>
    </div>

    @if(in_array(auth()->user()->role_id, [1, 2]))
    <a href="{{ route('inventario.lotes.create') }}" class="btn-main">
        + Nuevo Lote
    </a>
    @endif
</div>

    <!-- TABLA -->
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
                    <span class="badge-soft
                    {{ $lote->estado=='activo' ? 'success' :
                       ($lote->estado=='agotado' ? 'danger' : 'warning') }}">
                       {{ ucfirst($lote->estado) }}
                    </span>
                </td>

                <td>{{ $lote->registrador->name ?? 'Sistema' }}</td>

                <td class="actions text-end">
                    <a href="{{ route('inventario.lotes.show', $lote) }}">👁</a>
                    <a href="{{ route('inventario.movimientos.entrada', $lote) }}">➕</a>
                    <a href="{{ route('inventario.movimientos.salida', $lote) }}">➖</a>
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
        No hay lotes registrados 📦
    </div>

    @endif

</div>
</div>

@endsection