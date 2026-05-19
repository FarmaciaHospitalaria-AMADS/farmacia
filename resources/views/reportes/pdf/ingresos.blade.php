<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingresos de Suministros</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1e293b; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0f172a; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; color: #0f172a; }
        .header p { margin: 4px 0 0; color: #64748b; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #0f172a; color: #ffffff; padding: 8px 10px; text-align: left; font-size: 11px; text-transform: uppercase; }
        td { padding: 7px 10px; border-bottom: 1px solid #e2e8f0; font-size: 11px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ingresos de Suministros</h1>
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Insumo</th>
                <th>Lote</th>
                <th>Cantidad</th>
                <th>Proveedor</th>
                <th>Registrado por</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movimientos as $movimiento)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($movimiento->fecha)->format('d/m/Y H:i') }}</td>
                    <td>{{ $movimiento->lote->insumo->nombre ?? 'N/A' }}</td>
                    <td>{{ $movimiento->lote->codigo_lote ?? 'N/A' }}</td>
                    <td>+{{ $movimiento->cantidad }}</td>
                    <td>{{ $movimiento->lote->proveedor ?? 'N/A' }}</td>
                    <td>{{ $movimiento->usuario->name ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;">No hay registros.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Total: {{ $movimientos->count() }} registros</div>
</body>
</html>