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
        -webkit-font-smoothing: auto; 
    }
    
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .title-wrapper h1 {
        font-size: 1.85rem;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.03em;
        margin: 0;
    }

    .btn-primary-custom {
        background-color: #0f172a;
        color: #ffffff;
        border: none;
        padding: 0.6rem 1.25rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9rem;
        display: flex;
        align-items: center; gap: 0.5rem;
        cursor: pointer;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        gap: 1rem;
    }

    .search-box {
        position: relative;
        width: 350px;
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .search-box input {
        width: 100%;
        padding: 0.6rem 1rem 0.6rem 2.8rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9rem;
        outline: none;
    }

    .table-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table th {
        background-color: #f8fafc;
        color: #1e293b;
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 800;
        padding: 1.2rem 1.5rem;
        text-align: left;
        border-bottom: 2px solid #e2e8f0;
    }

    .custom-table td {
        padding: 1.2rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    .provider-details strong {
        display: block;
        color: #000000 !important; 
        font-size: 0.95rem;
        font-weight: 800 !important; 
        line-height: 1.4;
    }

    .provider-details span {
        color: #475569;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .avatar {
        width: 42px; height: 42px; border-radius: 10px;
        background: #eff6ff; color: #2563eb;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; border: 1.5px solid #dbeafe;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.9rem;
        border-radius: 9999px;
        font-size: 0.8rem;
        font-weight: 800 !important; 
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .status-badge i { font-size: 0.5rem; }

    .status-badge-activo { background-color: #ecfdf5 !important; color: #047857 !important; border-color: #10b981 !important; }
    .status-badge-inactivo { background-color: #fef2f2 !important; color: #b91c1c !important; border-color: #f87171 !important; }
    .status-badge-cuarentena { background-color: #fffbeb !important; color: #92400e !important; border-color: #f59e0b !important; }
    .status-badge-agotado { background-color: #fff1f2 !important; color: #9f1239 !important; border-color: #fb7185 !important; }
    .status-badge-descontinuado { background-color: #f8fafc !important; color: #475569 !important; border-color: #cbd5e1 !important; }

    .btn-icon {
        background: transparent; border: none; color: #94a3b8;
        width: 36px; height: 36px; font-size: 1.25rem; cursor: pointer;
    }

    .table-footer {
        padding: 1.5rem;
        background-color: #ffffff;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #64748b;
    }
</style>

<div class="dashboard-premium">
    <div class="header-section">
        <div class="title-wrapper">
            <h1>Proveedores</h1>
            <p>Directorio centralizado de laboratorios y proveedores.</p>
        </div>
        <button class="btn-primary-custom">
            <i class='bx bx-plus'></i> Nuevo Proveedor
        </button>
    </div>

    <div class="table-card">
        <div class="toolbar">
            <div class="search-box">
                <i class='bx bx-search'></i>
                <input type="text" id="inputBuscarProveedor" placeholder="Buscar proveedor...">
            </div>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 30%;">Proveedor</th>
                    <th style="width: 25%;">Contacto</th>
                    <th style="width: 25%;">Ubicación</th>
                    <th style="width: 10%;">Estado</th>
                    <th style="width: 10%; text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody id="cuerpoTablaProveedores">
                <tr><td colspan="5" style="text-align:center; padding:3rem;">Cargando...</td></tr>
            </tbody>
        </table>

        <div class="table-footer">
            <span id="contadorResultados">Mostrando resultados</span>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', cargarProveedores);

    async function cargarProveedores() {
        const tabla = document.getElementById('cuerpoTablaProveedores');
        try {
            const response = await fetch('/api/proveedores');
            const proveedores = await response.json();
            tabla.innerHTML = '';

            const inputBuscar = document.getElementById('inputBuscarProveedor');
            inputBuscar.addEventListener('keyup', function() {
                let filtro = this.value.toLowerCase();
                document.querySelectorAll('#cuerpoTablaProveedores tr').forEach(fila => {
                    fila.style.display = fila.innerText.toLowerCase().includes(filtro) ? '' : 'none';
                });
            });

            document.getElementById('contadorResultados').innerHTML = `Mostrando <strong>${proveedores.length}</strong> resultados`;

            proveedores.forEach(p => {
                const iniciales = p.nombre ? p.nombre.substring(0, 2).toUpperCase() : 'PR';
                
                let claseCss = '';
                switch(p.estado_id) {
                    case 1: claseCss = 'status-badge-activo'; break;
                    case 2: claseCss = 'status-badge-inactivo'; break;
                    case 3: claseCss = 'status-badge-cuarentena'; break;
                    case 4: claseCss = 'status-badge-agotado'; break;
                    case 5: claseCss = 'status-badge-descontinuado'; break;
                    default: claseCss = 'status-badge-descontinuado';
                }

                const nombreEstado = p.estado ? p.estado.nombre : 'N/A';

                tabla.innerHTML += `
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div class="avatar">${iniciales}</div>
                                <div class="provider-details">
                                    <strong>${p.nombre}</strong>
                                    <span>ID: #${p.id}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="provider-details">
                                <strong>${p.email || 'Sin email'}</strong>
                                <span>Tel: ${p.telefono || 'Sin teléfono'}</span>
                            </div>
                        </td>
                        <td>
                            <div class="provider-details">
                                <strong>${p.direccion || 'No especificada'}</strong>
                                <span>Ubicación registrada</span>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge ${claseCss}">
                                <i class='bx bxs-circle'></i> ${nombreEstado}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; justify-content: flex-end; gap: 5px;">
                                <button class="btn-icon"><i class='bx bx-edit-alt'></i></button>
                                <button class="btn-icon"><i class='bx bx-trash'></i></button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        } catch (error) {
            console.error(error);
            tabla.innerHTML = '<tr><td colspan="5" style="text-align:center; color:red; padding:2rem;">Error al cargar datos</td></tr>';
        }
    }
</script>
@endsection