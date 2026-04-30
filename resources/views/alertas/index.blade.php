@extends('layouts.app')

@section('title', 'Alertas del Sistema')

@section('content')

<h2>Alertas del Sistema</h2>

{{-- Mensajes de éxito --}}
@if(session('success'))
<p style="color: green;">{{ session('success') }}</p>
@endif

{{-- Resumen --}}
<div style="display: flex; gap: 20px; margin-bottom: 20px;">
    <div style="background: #fff3cd; padding: 15px; border-radius: 8px; flex: 1; text-align: center;">
        <h3>⚠️ Stock Bajo</h3>
        <p style="font-size: 2rem; margin: 0;">{{ $totalStockBajo }}</p>
    </div>
    <div style="background: #f8d7da; padding: 15px; border-radius: 8px; flex: 1; text-align: center;">
        <h3>Por Vencer</h3>
        <p style="font-size: 2rem; margin: 0;">{{ $totalPorVencer }}</p>
    </div>
    <div style="background: #d1ecf1; padding: 15px; border-radius: 8px; flex: 1; text-align: center;">
        <h3>Total</h3>
        <p style="font-size: 2rem; margin: 0;">{{ $alertas->count() }}</p>
    </div>
</div>

{{-- Botón marcar todas como leídas --}}
@if($alertas->count() > 0)
<form action="{{ route('alertas.todasLeidas') }}" method="POST" style="margin-bottom: 15px;">
    @csrf
    <button type="submit" style="background: #6c757d; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer;">
        Marcar todas como leídas
    </button>
</form>
@endif

{{-- Tabla de alertas --}}
@if($alertas->count() > 0)
<table style="width: 100%; border-collapse: collapse; background: white;">
    <thead style="background: #333; color: white;">
        <tr>
            <th style="padding: 10px; text-align: left;">Tipo</th>
            <th style="padding: 10px; text-align: left;">Insumo</th>
            <th style="padding: 10px; text-align: left;">Mensaje</th>
            <th style="padding: 10px; text-align: left;">Fecha</th>
            <th style="padding: 10px; text-align: left;">Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach($alertas as $alerta)
        <tr style="border-bottom: 1px solid #ddd;">
            <td style="padding: 10px;">
                @if($alerta->tipo === 'stock_bajo')
                <span style="background: #fff3cd; padding: 3px 8px; border-radius: 4px;">⚠️ Stock Bajo</span>
                @else
                <span style="background: #f8d7da; padding: 3px 8px; border-radius: 4px;">📅 Por Vencer</span>
                @endif
            </td>
            <td style="padding: 10px;">{{ $alerta->insumo->nombre ?? 'N/A' }}</td>
            <td style="padding: 10px;">{{ $alerta->mensaje }}</td>
            <td style="padding: 10px;">{{ $alerta->created_at->format('d/m/Y H:i') }}</td>
            <td style="padding: 10px;">
                <form action="{{ route('alertas.leida', $alerta->id) }}" method="POST">
                    @csrf
                    <button type="submit" style="background: #28a745; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;">
                        Marcar leída
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div style="background: #d4edda; padding: 20px; border-radius: 8px; text-align: center;">
    <p style="margin: 0; color: #155724;">✅ No hay alertas pendientes.</p>
</div>
@endif

@endsection