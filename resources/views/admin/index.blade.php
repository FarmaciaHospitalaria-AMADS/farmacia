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

    .icon-users { background: #eff6ff; color: #3b82f6; }
    .icon-providers { background: #f5f3ff; color: #8b5cf6; }
    .icon-items { background: #ecfdf5; color: #10b981; }
    .icon-alerts { background: #fef2f2; color: #ef4444; }

    .kpi-details h3 { margin: 0; font-size: 1.85rem; font-weight: 800; color: #0f172a; line-height: 1.2; }
    .kpi-details span { font-size: 0.85rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }

    .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; }
    .section-card { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 2rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .section-title { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }

    .quick-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .action-btn { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.75rem; padding: 1.5rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; color: #334155; font-weight: 600; text-decoration: none; transition: all 0.2s; }
    .action-btn i { font-size: 2rem; color: #0f172a; }
    .action-btn:hover { background: #0f172a; color: #ffffff; border-color: #0f172a; }
    .action-btn:hover i { color: #ffffff; }

    .alert-item { display: flex; align-items: flex-start; gap: 1rem; padding-bottom: 1rem; margin-bottom: 1rem; border-bottom: 1px solid #f1f5f9; }
    .alert-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .alert-bullet { width: 10px; height: 10px; border-radius: 50%; background: #ef4444; margin-top: 6px; }
    .alert-text strong { display: block; color: #0f172a; font-size: 0.9rem; }
    .alert-text span { color: #64748b; font-size: 0.8rem; }
</style>

<div class="dashboard-premium">
    <div class="header-section">
        <div class="title-wrapper">
            <h1>Panel de Administración</h1>
            <p>Resumen general y control total del sistema de salud.</p>
        </div>
    </div>

    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon icon-users"><i class='bx bx-user'></i></div>
            <div class="kpi-details">
                <h3>{{ $totalUsuarios }}</h3>
                <span>Usuarios Activos</span>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon icon-providers"><i class='bx bx-buildings'></i></div>
            <div class="kpi-details">
                <h3>{{ $totalProveedores }}</h3>
                <span>Proveedores</span>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon icon-items"><i class='bx bx-box'></i></div>
            <div class="kpi-details">
                <h3>{{ $totalInsumos }}</h3>
                <span>Insumos Registrados</span>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon icon-alerts"><i class='bx bx-error-circle'></i></div>
            <div class="kpi-details">
                <h3>{{ $totalAlertas }}</h3>
                <span>Alertas Activas</span>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div class="section-card">
            <h2 class="section-title"><i class='bx bx-paper-plane'></i> Accesos Rápidos</h2>
            <div class="quick-actions">
                <a href="/admin/usuarios" class="action-btn">
                    <i class='bx bx-user-plus'></i> Gestionar Usuarios
                </a>
                <a href="/admin/proveedores" class="action-btn">
                    <i class='bx bx-store-alt'></i> Directorio Proveedores
                </a>
                <a href="/admin/insumos" class="action-btn">
                    <i class='bx bx-package'></i> Inventario Insumos
                </a>
                <a href="/alertas" class="action-btn">
                    <i class='bx bx-bell'></i> Centro de Alertas
                </a>
            </div>
        </div>

        <div class="section-card">
            <h2 class="section-title"><i class='bx bx-bell'></i> Alertas Activas</h2>
            <div class="alert-list">
                <div class="alert-item">
                    <div class="alert-bullet"></div>
                    <div class="alert-text">
                        <strong>Sistema Activo</strong>
                        <span>Monitoreo funcionando correctamente</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection