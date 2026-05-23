@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<style>
    .dashboard-premium { font-family: 'Inter', sans-serif; padding: 2.5rem 3.5rem; background-color: #f8fafc; min-height: 85vh; }
    .header-section { margin-bottom: 2.5rem; }
    .title-wrapper h1 { font-size: 2rem; font-weight: 800; color: #0f172a; margin: 0; }
    .title-wrapper p { color: #64748b; font-size: 1rem; margin: 0.4rem 0 0 0; }

    .kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 3rem; }
    .kpi-card { background: #ffffff; border-radius: 16px; padding: 1.5rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 1.25rem; transition: transform 0.2s ease; }
    .kpi-card:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
    .kpi-icon { width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; flex-shrink: 0; }

    .icon-items { background: #ecfdf5; color: #10b981; }
    .icon-providers { background: #eff6ff; color: #3b82f6; }
    .icon-warning { background: #fffbeb; color: #f59e0b; }
    .icon-alerts { background: #fef2f2; color: #ef4444; }

    .kpi-details h3 { margin: 0; font-size: 1.85rem; font-weight: 800; color: #0f172a; line-height: 1.2; }
    .kpi-details span { font-size: 0.85rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }

    .section-card { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 2rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .section-title { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }

    /* Ajustado para que los 3 botones se repartan parejitos */
    .quick-actions { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; }
    .action-btn { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.75rem; padding: 1.5rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; color: #334155; font-weight: 600; text-decoration: none; transition: all 0.2s; }
    .action-btn i { font-size: 2rem; color: #0f172a; }
    .action-btn:hover { background: #0f172a; color: #ffffff; border-color: #0f172a; } 
    .action-btn:hover i { color: #ffffff; }
</style>

<div class="dashboard-premium">
    <div class="header-section">
        <div class="title-wrapper">
            <h1>Área de Farmacia</h1>
            <p>Control de inventario, proveedores y suministros médicos.</p>
        </div>
    </div>

    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon icon-items"><i class='bx bx-package'></i></div>
            <div class="kpi-details">
                <h3>{{ $totalInsumos }}</h3>
                <span>Total Insumos</span>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon icon-providers"><i class='bx bx-store-alt'></i></div>
            <div class="kpi-details">
                <h3>{{ $totalProveedores }}</h3>
                <span>Proveedores</span>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon icon-warning"><i class='bx bx-trending-down'></i></div>
            <div class="kpi-details">
                <h3>{{ $stockCritico }}</h3>
                <span>Stock Crítico</span>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon icon-alerts"><i class='bx bx-bell'></i></div>
            <div class="kpi-details">
                <h3>{{ $alertasPendientes }}</h3>
                <span>Alertas No Leídas</span>
            </div>
        </div>
    </div>

    <div class="section-card">
        <h2 class="section-title"><i class='bx bx-paper-plane'></i> Accesos Rápidos</h2>
        <div class="quick-actions">
            <a href="/admin/insumos" class="action-btn">
                <i class='bx bx-box'></i> Inventario Insumos
            </a>
            <a href="/admin/proveedores" class="action-btn">
                <i class='bx bx-buildings'></i> Directorio Proveedores
            </a>
            <a href="/alertas" class="action-btn">
                <i class='bx bx-bell'></i> Centro de Alertas
            </a>
        </div>
    </div>
</div>
@endsection