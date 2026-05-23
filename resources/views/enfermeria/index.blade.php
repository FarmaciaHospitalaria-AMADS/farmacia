@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<style>
    .dashboard-premium {
        font-family: 'Inter', sans-serif;
        padding: 2.5rem 3.5rem;
        background-color: #f8fafc;
        min-height: 85vh;
    }
    
    .header-section { margin-bottom: 2.5rem; }

    .title-wrapper h1 { font-size: 2rem; font-weight: 800; color: #0f172a; margin: 0; }
    .title-wrapper p { color: #64748b; font-size: 1rem; margin: 0.4rem 0 0 0; }

    .kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 3rem; }
    .kpi-card { background: #ffffff; border-radius: 16px; padding: 1.5rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 1.25rem; transition: transform 0.2s ease; }
    .kpi-card:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
    .kpi-icon { width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; flex-shrink: 0; }

    /* Colores orientados a Enfermería */
    .icon-process { background: #eff6ff; color: #3b82f6; }
    .icon-done { background: #ecfdf5; color: #10b981; }
    .icon-alerts { background: #fdf2f8; color: #db2777; }
    .icon-items { background: #f0fdfa; color: #0d9488; }

    .kpi-details h3 { margin: 0; font-size: 1.85rem; font-weight: 800; color: #0f172a; line-height: 1.2; }
    .kpi-details span { font-size: 0.85rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }

    .section-card { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 2rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .section-title { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }

    /* Estilos de la tabla de movimientos */
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { background-color: #f8fafc; color: #1e293b; font-size: 0.75rem; text-transform: uppercase; font-weight: 800; padding: 1.2rem 1.5rem; text-align: left; border-bottom: 2px solid #e2e8f0; }
    .custom-table td { padding: 1.2rem 1.5rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }

    .status-badge { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.9rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 800 !important; }
    .status-badge-activo { background-color: #ecfdf5; color: #047857; border: 1px solid #10b981; }
    .status-badge-inactivo { background-color: #fef2f2; color: #b91c1c; border: 1px solid #f87171; }

    .alert-text strong { display: block; color: #0f172a; font-size: 0.95rem; font-weight: 700; }
    .alert-text span { color: #64748b; font-size: 0.85rem; }
    
    .empty-state { text-align: center; padding: 4rem 2rem; color: #64748b; }
    .empty-state i { font-size: 4rem; color: #cbd5e1; margin-bottom: 1rem; }
    .empty-state h3 { color: #0f172a; font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem; }
</style>

<div class="dashboard-premium">
    <div class="header-section">
        <div class="title-wrapper">
            <h1>Área de Enfermería</h1>
            <p>Control y monitoreo de movimientos diarios de insumos.</p>
        </div>
    </div>

    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon icon-process"><i class='bx bx-transfer-alt'></i></div>
            <div class="kpi-details">
                <h3>{{ $movimientosHoy }}</h3>
                <span>Total Movimientos Hoy</span>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon icon-done"><i class='bx bx-trending-up'></i></div>
            <div class="kpi-details">
                <h3>{{ $entradasHoy }}</h3>
                <span>Entradas de Hoy</span>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon icon-alerts"><i class='bx bx-trending-down'></i></div>
            <div class="kpi-details">
                <h3>{{ $salidasHoy }}</h3>
                <span>Salidas / Consumo</span>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon icon-items"><i class='bx bx-box'></i></div>
            <div class="kpi-details">
                <h3>{{ $totalInsumos }}</h3>
                <span>Insumos Totales</span>
            </div>
        </div>
    </div>

    <div class="section-card">
        <h2 class="section-title"><i class='bx bx-list-ul'></i> Registro Diario de Movimientos</h2>

        @if(count($detalleMovimientos) > 0)
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 15%;">Hora</th>
                        <th style="width: 15%;">Tipo</th>
                        <th style="width: 20%;">Cantidad</th>
                        <th style="width: 50%;">Motivo / Referencia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detalleMovimientos as $mov)
                        <tr>
                            <td><strong style="color: #0f172a;">{{ \Carbon\Carbon::parse($mov->created_at)->format('h:i A') }}</strong></td>
                            
                            <td>
                                @if(strtolower($mov->tipo) == 'entrada')
                                    <span class="status-badge status-badge-activo"><i class='bx bx-up-arrow-alt'></i> Entrada</span>
                                @else
                                    <span class="status-badge status-badge-inactivo"><i class='bx bx-down-arrow-alt'></i> Salida</span>
                                @endif
                            </td>
                            
                            <td><strong style="font-size: 1.1rem; color: #0f172a;">{{ $mov->cantidad }}</strong> <span style="color: #64748b; font-size: 0.85rem;">unidades</span></td>
                            
                            <td>
                                <div class="alert-text">
                                    <strong>{{ $mov->motivo ?: 'Sin motivo especificado' }}</strong>
                                    <span>Ref: {{ $mov->referencia ?: 'N/A' }}</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class='bx bx-calendar-x'></i>
                <h3>El día está tranquilo</h3>
                <p>Aún no hay movimientos (entradas o salidas) registrados el día de hoy.</p>
                <p style="font-size: 0.85rem; margin-top: 1rem;">Cualquier movimiento nuevo aparecerá aquí automáticamente.</p>
            </div>
        @endif
    </div>
</div>
@endsection