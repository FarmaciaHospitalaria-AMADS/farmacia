@extends('layouts.app')
@section('title', 'Stock Actual')
@section('content')
<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Stock Actual</h2>
            <p class="text-muted small mb-0">Estado actual del inventario de insumos y medicamentos.</p>
        </div>
        <a href="{{ route('reportes.stock.pdf') }}" class="btn btn-dark">
            <i class='bx bxs-file-pdf'></i> Descargar PDF
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center border-bottom pb-3">
            <div class="input-group w-auto" style="min-width: 280px;">
                <span class="input-group-text bg-white border-end-0"><i class='bx bx-search text-muted'></i></span>
                <input type="text" id="buscarStock" class="form-control border-start-0" placeholder="Buscar insumo...">
            </div>
            <span class="text-muted small"><strong>{{ $insumos->count() }}</strong> insumos registrados</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tablaStock">
                <thead class="table-light">
                    <tr>
                        <th class="text-uppercase small fw-black">Insumo</th>
                        <th class="text-uppercase small fw-black">Categoría</th>
                        <th class="text-uppercase small fw-black">Proveedor</th>
                        <th class="text-uppercase small fw-black">Stock Total</th>
                        <th class="text-uppercase small fw-black">Stock Mínimo</th>
                        <th class="text-uppercase small fw-black">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($insumos as $insumo)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 bg-primary bg-opacity-10 text-primary fw-black d-flex align-items-center justify-content-center" style="width:42px;height:42px;font-size:0.85rem">
                                    {{ strtoupper(substr($insumo->nombre, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="fw-bold mb-0">{{ $insumo->nombre }}</p>
                                    <p class="text-muted small mb-0">{{ $insumo->codigo ?? 'Sin código' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="text-muted">{{ $insumo->categoria->nombre ?? 'N/A' }}</td>
                        <td class="text-muted">{{ $insumo->proveedor->nombre ?? 'N/A' }}</td>
                        <td class="fw-bold">{{ $insumo->stock_total }}</td>
                        <td class="text-muted">{{ $insumo->stock_minimo }}</td>
                        <td>
                            @if($insumo->stock_total <= $insumo->stock_minimo)
                                <span class="badge rounded-pill bg-warning text-dark">⚠️ Stock Bajo</span>
                            @else
                                <span class="badge rounded-pill bg-success">✅ Normal</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class='bx bx-package d-block mb-2' style="font-size:2.5rem"></i>
                            No hay insumos registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted small bg-white">
            Mostrando <strong>{{ $insumos->count() }}</strong> resultados
        </div>
    </div>
</div>
<script>
    document.getElementById('buscarStock').addEventListener('keyup', function() {
        const filtro = this.value.toLowerCase();
        document.querySelectorAll('#tablaStock tbody tr').forEach(fila => {
            fila.style.display = fila.innerText.toLowerCase().includes(filtro) ? '' : 'none';
        });
    });
</script>
@endsection