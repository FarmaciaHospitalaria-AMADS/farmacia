<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Stock</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1e293b; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0f172a; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; color: #0f172a; }
        .header p { margin: 4px 0 0; color: #64748b; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #0f172a; color: #ffffff; padding: 8px 10px; text-align: left; font-size: 11px; text-transform: uppercase; }
        td { padding: 7px 10px; border-bottom: 1px solid #e2e8f0; font-size: 11px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .badge-ok  { background: #ecfdf5; color: #047857; padding: 2px 8px; border-radius: 999px; font-size: 10px; font-weight: bold; }
        .badge-low { background: #fffbeb; color: #92400e; padding: 2px 8px; border-radius: 999px; font-size: 10px; font-weight: bold; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Stock Actual</h1>
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Insumo</th>
                <th>Código</th>
                <th>Categoría</th>
                <th>Proveedor</th>
                <th>Stock Total</th>
                <th>Stock Mínimo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($insumos as $insumo)
                <tr>
                    <td>{{ $insumo->nombre }}</td>
                    <td>{{ $insumo->codigo ?? 'N/A' }}</td>
                    <td>{{ $insumo->categoria->nombre ?? 'N/A' }}</td>
                    <td>{{ $insumo->proveedor->nombre ?? 'N/A' }}</td>
                    <td>{{ $insumo->stock_total }}</td>
                    <td>{{ $insumo->stock_minimo }}</td>
                    <td>
                        @if($insumo->stock_total <= $insumo->stock_minimo)
                            <span class="badge-low">Stock Bajo</span>
                        @else
                            <span class="badge-ok">Normal</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;">No hay registros.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Total: {{ $insumos->count() }} insumos</div>
</body>
</html>