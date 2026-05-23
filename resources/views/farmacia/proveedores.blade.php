@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<style>
    .dashboard-premium { font-family: 'Inter', sans-serif; padding: 2.5rem 3.5rem; background-color: #f8fafc; min-height: 85vh; -webkit-font-smoothing: auto; }
    .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .title-wrapper h1 { font-size: 1.85rem; font-weight: 700; color: #0f172a; letter-spacing: -0.03em; margin: 0; }
    .btn-primary-custom { background-color: #0f172a; color: #ffffff; border: none; padding: 0.6rem 1.25rem; border-radius: 8px; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
    .toolbar { display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; gap: 1rem; }
    .search-box { position: relative; width: 350px; }
    .search-box i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 1.2rem; }
    .search-box input { width: 100%; padding: 0.6rem 1rem 0.6rem 2.8rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem; outline: none; }
    .table-card { background: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; overflow: hidden; }
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { background-color: #f8fafc; color: #1e293b; font-size: 0.75rem; text-transform: uppercase; font-weight: 800; padding: 1.2rem 1.5rem; text-align: left; border-bottom: 2px solid #e2e8f0; }
    .custom-table td { padding: 1.2rem 1.5rem; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
    .provider-details strong { display: block; color: #000000 !important; font-size: 0.95rem; font-weight: 800 !important; line-height: 1.4; }
    .provider-details span { color: #475569; font-size: 0.8rem; font-weight: 500; }
    .avatar { width: 42px; height: 42px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-weight: 800; border: 1.5px solid #dbeafe; }
    .status-badge { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.9rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 800 !important; border: 1px solid transparent; white-space: nowrap; }
    .status-badge i { font-size: 0.5rem; }
    .status-badge-activo { background-color: #ecfdf5 !important; color: #047857 !important; border-color: #10b981 !important; }
    .status-badge-inactivo { background-color: #fef2f2 !important; color: #b91c1c !important; border-color: #f87171 !important; }
    .status-badge-cuarentena { background-color: #fffbeb !important; color: #92400e !important; border-color: #f59e0b !important; }
    .status-badge-agotado { background-color: #fff1f2 !important; color: #9f1239 !important; border-color: #fb7185 !important; }
    .status-badge-descontinuado { background-color: #f8fafc !important; color: #475569 !important; border-color: #cbd5e1 !important; }
    .btn-icon { background: transparent; border: none; color: #94a3b8; width: 36px; height: 36px; font-size: 1.25rem; cursor: pointer; }
    .table-footer { padding: 1.5rem; background-color: #ffffff; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; color: #64748b; }
</style>

<style>
    /* Estilos extra y Modales */
    .btn-secondary { background-color: #ffffff; color: #334155; border: 1px solid #e2e8f0; padding: 0.6rem 1rem; border-radius: 8px; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 0.4rem; cursor: pointer; }
    .btn-secondary:disabled { opacity: 0.5; cursor: not-allowed; }
    .btn-icon { border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; transition: 0.2s; }
    .btn-icon:hover { background-color: #f1f5f9; color: #0f172a; }
    .btn-icon.delete:hover { background-color: #fef2f2; color: #ef4444; }

    .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); justify-content: center; align-items: center; z-index: 1050; }
    .modal-content { background: #ffffff; padding: 2rem; border-radius: 12px; width: 100%; max-width: 500px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border: 1px solid #e2e8f0; max-height: 90vh; overflow-y: auto; }
    .modal-content h3 { margin-top: 0; color: #0f172a; font-weight: 800; font-size: 1.25rem; margin-bottom: 1.5rem; }
    .form-row { display: flex; gap: 1rem; }
    .form-group { margin-bottom: 1rem; width: 100%; }
    .form-group label { display: block; margin-bottom: 0.4rem; font-weight: 600; color: #475569; font-size: 0.85rem;}
    .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 0.75rem 1rem; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 0.9rem; outline: none; transition: all 0.2s; box-sizing: border-box; }
    .form-group input:focus, .form-group textarea:focus, .form-group select:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    .modal-acciones { display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem; }
    .btn-cancelar { background-color: #f8fafc; color: #475569; border: 1px solid #e2e8f0; padding: 0.6rem 1.25rem; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s; width: 100%; text-align: center;}
    .btn-cancelar:hover { background-color: #f1f5f9; }
    .btn-danger-custom { background-color: #ef4444; color: #ffffff; border: none; padding: 0.6rem 1.25rem; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s; width: 100%; text-align: center; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2); }
    .btn-danger-custom:hover { background-color: #dc2626; }

    #toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; pointer-events: none; }
    .toast-custom { display: flex; align-items: center; gap: 12px; min-width: 280px; max-width: 350px; padding: 14px 18px; background-color: #ffffff; border-radius: 10px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); border-left: 4px solid transparent; font-family: 'Inter', sans-serif; animation: slideIn 0.3s ease forwards; transition: opacity 0.3s ease; }
    .toast-success { border-left-color: #10b981; }
    .toast-error { border-left-color: #ef4444; }
    .toast-icon { font-size: 1.5rem; display: flex; align-items: center; }
    .toast-success .toast-icon { color: #10b981; }
    .toast-error .toast-icon { color: #ef4444; }
    .toast-content { display: flex; flex-direction: column; }
    .toast-title { font-weight: 700; font-size: 0.85rem; color: #0f172a; margin-bottom: 2px; }
    .toast-message { font-size: 0.8rem; color: #64748b; line-height: 1.3; }
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        /* FILTRO DROPDOWN */
    .filter-wrapper { position: relative; }
    .filter-dropdown { display: none; position: absolute; right: 0; top: 110%; background: white; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); width: 180px; z-index: 100; }
    .filter-dropdown button { display: block; width: 100%; text-align: left; padding: 0.75rem 1rem; border: none; background: none; font-size: 0.85rem; color: #475569; cursor: pointer; transition: 0.2s; }
    .filter-dropdown button:hover { background: #f8fafc; color: #0f172a; font-weight: 600; }
</style>

<div id="toast-container"></div>

<div class="dashboard-premium">
    <div class="header-section">
        <div class="title-wrapper">
            <h1>Proveedores</h1>
            <p>Directorio centralizado de laboratorios y distribuidores.</p>
        </div>
        <button class="btn-primary-custom" onclick="abrirModalCrear()">
            <i class='bx bx-plus'></i> Nuevo Proveedor
        </button>
    </div>

    <div class="table-card">
        <div class="toolbar">
            <div class="search-box">
                <i class='bx bx-search'></i>
                <input type="text" id="inputBuscarProveedor" placeholder="Buscar proveedor por nombre, email o teléfono..." oninput="filtrarDatos()">
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <div class="filter-wrapper">
                    <button class="btn-secondary" onclick="document.getElementById('filter-dropdown-proveedores').style.display = (document.getElementById('filter-dropdown-proveedores').style.display === 'block' ? 'none' : 'block')">
                        <i class='bx bx-filter-alt'></i> Filtro: <span id="filtro-actual">Todo</span>
                    </button>
                    <div id="filter-dropdown-proveedores" class="filter-dropdown">
                        <button onclick="setFiltro('todo', 'Todo')">Todo</button>
                        <button onclick="setFiltro('nombre', 'Nombre')">Nombre</button>
                        <button onclick="setFiltro('email', 'Correo')">Correo</button>
                        <button onclick="setFiltro('telefono', 'Teléfono')">Teléfono</button>
                        <button onclick="setFiltro('estado', 'Estado')">Estado</button>
                    </div>
                </div>
                <button class="btn-secondary"><i class='bx bx-export'></i> Exportar</button>
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
                <tr><td colspan="5" style="text-align:center; padding:3rem; color: #64748b;">Cargando directorio...</td></tr>
            </tbody>
        </table>

        <div class="table-footer">
            <span id="contadorResultados">Mostrando resultados</span>
            <div style="display: flex; gap: 0.5rem;">
                <button class="btn-secondary" id="btn-prev" onclick="cambiarPagina(-1)" style="padding: 0.4rem 0.8rem;">Anterior</button>
                <button class="btn-secondary" id="btn-next" onclick="cambiarPagina(1)" style="padding: 0.4rem 0.8rem;">Siguiente</button>
            </div>
        </div>
    </div>
</div>

<div id="modal-formulario" class="modal-overlay">
    <div class="modal-content">
        <h3 id="modal-titulo">Registrar Proveedor</h3>
        <form id="formulario-datos" onsubmit="guardarRegistro(event)">
            <input type="hidden" id="proveedor-id">
            
            <div class="form-group">
                <label>Nombre / Razón Social:</label>
                <input type="text" id="proveedor-nombre" required placeholder="Ej: Laboratorios Pfizer">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Teléfono:</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <input type="text" id="proveedor-prefijo" value="+503" style="width: 80px; text-align: center; padding-left: 0.5rem; padding-right: 0.5rem;" placeholder="Prefijo">
                        <input type="text" id="proveedor-telefono" placeholder="####-####" oninput="formatearTelefono(this)" style="flex: 1;">
                    </div>
                </div>
                <div class="form-group">
                    <label>Correo Electrónico:</label>
                    <input type="email" id="proveedor-email" placeholder="Ej: contacto@pfizer.com">
                </div>
            </div>

            <div class="form-group">
                <label>Dirección Física:</label>
                <textarea id="proveedor-direccion" rows="2" placeholder="Ubicación de la sucursal..."></textarea>
            </div>

            <div class="form-group" id="grupo-estado">
                <label>Estado Inicial:</label>
                <select id="proveedor-estado">
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                    <option value="3">En Cuarentena</option>
                    <option value="4">Agotado / Sin Stock</option>
                    <option value="5">Descontinuado</option>
                </select>
            </div>
            
            <div class="modal-acciones">
                <button type="button" class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
                <button type="submit" class="btn-primary-custom" style="margin: 0; width: 100%; justify-content: center; box-shadow: none;">Guardar Proveedor</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-eliminar" class="modal-overlay">
    <div class="modal-content">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <div style="width: 60px; height: 60px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto; font-size: 2rem;">
                <i class='bx bx-building-house'></i>
            </div>
            <h3 style="margin-bottom: 0.5rem; color: #1e293b;">Confirmar Eliminación</h3>
            <p style="color: #64748b; font-size: 0.9rem; margin: 0;">¿Está seguro que desea borrar este proveedor de la base de datos?</p>
        </div>
        
        <div style="background: #f8fafc; padding: 1.25rem; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 1.5rem;">
            <p style="margin: 0 0 0.5rem 0; font-size: 0.85rem; color: #64748b;"><strong>ID Proveedor:</strong> <span id="eliminar-id-text"></span></p>
            <p style="margin: 0 0 0.5rem 0; font-size: 0.85rem; color: #64748b;"><strong>Nombre:</strong> <span id="eliminar-nombre-text" style="color: #0f172a; font-weight: 700; font-size: 0.95rem;"></span></p>
            <p style="margin: 0; font-size: 0.85rem; color: #64748b;"><strong>Contacto:</strong> <span id="eliminar-contacto-text"></span></p>
        </div>
        
        <div class="modal-acciones" style="display: flex; gap: 1rem; margin-top: 0;">
            <button type="button" class="btn-cancelar" onclick="cerrarModalEliminar()">Cancelar</button>
            <button type="button" onclick="confirmarEliminacion()" class="btn-danger-custom">Sí, Eliminar</button>
        </div>
    </div>
</div>

<script>
    const urlBase = '/api';
    let proveedoresCompletos = [];
    let proveedoresFiltrados = [];
    
    let paginaActual = 1;
    const itemsPorPagina = 10;
    let idAEliminar = null;

    let filtroActivo = 'todo';

    // dormateo inteligente para teléfono: ####-####
    function formatearTelefono(input) {
        // Quitamos cualquier letra o caracter que no sea número
        let valor = input.value.replace(/\D/g, '');
        
        // Lo limitamos a un máximo de 8 números
        if (valor.length > 8) {
            valor = valor.substring(0, 8);
        }
        
        // Si ya hay más de 4 números, inyectamos el guion
        if (valor.length > 4) {
            valor = valor.substring(0, 4) + '-' + valor.substring(4);
        }
        
        // Actualizamos la caja de texto
        input.value = valor;
    }

    // notificaciones tipo toast
    function mostrarToast(mensaje, tipo = 'success') {
        const contenedor = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `toast-custom toast-${tipo}`;

        const icono = tipo === 'success' ? 'bx-check-circle' : 'bx-error-circle';
        const titulo = tipo === 'success' ? '¡Operación Exitosa!' : 'Atención';

        toast.innerHTML = `
            <div class="toast-icon"><i class='bx ${icono}'></i></div>
            <div class="toast-content">
                <span class="toast-title">${titulo}</span>
                <span class="toast-message">${mensaje}</span>
            </div>
        `;
        contenedor.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    }

    // Inicialización
    document.addEventListener('DOMContentLoaded', inicializar);

    async function inicializar() {
        try {
            const response = await fetch(`${urlBase}/proveedores`);
            proveedoresCompletos = await response.json();
            filtrarDatos();
        } catch (error) {
            console.error("Error cargando APIs", error);
            document.getElementById('cuerpoTablaProveedores').innerHTML = `<tr><td colspan="5" style="text-align:center; padding:3rem; color:red;">Error de conexión con la base de datos</td></tr>`;
            mostrarToast('No se pudieron cargar los datos del servidor.', 'error');
        }
    }

    function setFiltro(tipo, nombre) {
        filtroActivo = tipo;
        document.getElementById('filtro-actual').innerText = nombre;
        document.getElementById('filter-dropdown-proveedores').style.display = 'none';
        filtrarDatos();
    }

    function filtrarDatos() {
        const termino = document.getElementById('inputBuscarProveedor').value.toLowerCase();
        
        proveedoresFiltrados = proveedoresCompletos.filter(p => {
            const nombre = (p.nombre || '').toLowerCase();
            const email = (p.email || '').toLowerCase();
            const telefono = (p.telefono || '').toLowerCase();
            const nombreEstado = (p.estado ? p.estado.nombre : 'desconocido').toLowerCase();

            if (filtroActivo === 'todo') {
                return nombre.includes(termino) || email.includes(termino) || 
                    telefono.includes(termino) || nombreEstado.includes(termino);
            }
            if (filtroActivo === 'nombre') return nombre.includes(termino);
            if (filtroActivo === 'email') return email.includes(termino);
            if (filtroActivo === 'telefono') return telefono.includes(termino);
            if (filtroActivo === 'estado') return nombreEstado.includes(termino);
            
            return false;
        });

        paginaActual = 1; 
        renderizarTabla();
    }

    function renderizarTabla() {
        const tbody = document.getElementById('cuerpoTablaProveedores');
        tbody.innerHTML = '';
        document.getElementById('contadorResultados').innerHTML = `Mostrando <strong>${proveedoresFiltrados.length}</strong> proveedores`;

        if(proveedoresFiltrados.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" style="text-align:center; padding:3rem; color: #64748b;">No se encontraron proveedores.</td></tr>`;
            actualizarBotonesPaginacion();
            return;
        }

        const inicio = (paginaActual - 1) * itemsPorPagina;
        const fin = inicio + itemsPorPagina;
        const datosPagina = proveedoresFiltrados.slice(inicio, fin);

        datosPagina.forEach(p => {
            const iniciales = p.nombre ? p.nombre.substring(0, 2).toUpperCase() : 'PR';
            
            let claseCss = '';
            let textoEstado = p.estado ? p.estado.nombre : 'Desconocido';
            
            switch(p.estado_id) {
                case 1: claseCss = 'status-badge-activo'; textoEstado = 'Activo'; break;
                case 2: claseCss = 'status-badge-inactivo'; textoEstado = 'Inactivo'; break;
                case 3: claseCss = 'status-badge-cuarentena'; textoEstado = 'En Cuarentena'; break;
                case 4: claseCss = 'status-badge-agotado'; textoEstado = 'Agotado'; break;
                case 5: claseCss = 'status-badge-descontinuado'; textoEstado = 'Descontinuado'; break;
                default: claseCss = 'status-badge-descontinuado';
            }

            const jsonItem = JSON.stringify(p).replace(/'/g, "&apos;").replace(/"/g, "&quot;");

            tbody.innerHTML += `
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
                            <strong>${p.email || 'Sin correo registrado'}</strong>
                            <span>Tel: ${p.telefono || 'Sin teléfono'}</span>
                        </div>
                    </td>
                    <td>
                        <div class="provider-details">
                            <strong>${p.direccion || 'No especificada'}</strong>
                            <span>Ubicación de sede</span>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge ${claseCss}">
                            <i class='bx bxs-circle'></i> ${textoEstado}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; justify-content: flex-end; gap: 5px;">
                            <button class="btn-icon" onclick="abrirModalEditar('${jsonItem}')"><i class='bx bx-edit-alt'></i></button>
                            <button class="btn-icon delete" onclick="abrirModalEliminar(${p.id}, '${p.nombre}', '${p.email || p.telefono || 'Sin contacto'}')"><i class='bx bx-trash'></i></button>
                        </div>
                    </td>
                </tr>
            `;
        });

        actualizarBotonesPaginacion();
    }

    function actualizarBotonesPaginacion() {
        const totalPaginas = Math.ceil(proveedoresFiltrados.length / itemsPorPagina) || 1;
        document.getElementById('btn-prev').disabled = (paginaActual === 1);
        document.getElementById('btn-next').disabled = (paginaActual === totalPaginas);
    }

    function cambiarPagina(direccion) {
        const totalPaginas = Math.ceil(proveedoresFiltrados.length / itemsPorPagina);
        const nuevaPagina = paginaActual + direccion;
        if(nuevaPagina >= 1 && nuevaPagina <= totalPaginas) {
            paginaActual = nuevaPagina;
            renderizarTabla();
        }
    }

    // Control de Modales
    function abrirModalCrear() {
        document.getElementById('formulario-datos').reset();
        document.getElementById('proveedor-id').value = '';
        
        // Reiniciamos el teléfono y devolvemos el prefijo por defecto
        document.getElementById('proveedor-prefijo').value = '+503';
        document.getElementById('proveedor-telefono').value = '';
        
        // OCULTAMOS EL CAMPO DE ESTADO AL CREAR
        document.getElementById('grupo-estado').style.display = 'none'; 
        
        document.getElementById('modal-titulo').innerText = 'Registrar Nuevo Proveedor';
        document.getElementById('modal-formulario').style.display = 'flex';
    }

    function abrirModalEditar(itemString) {
        const p = JSON.parse(itemString.replace(/&quot;/g, '"').replace(/&apos;/g, "'"));
        
        document.getElementById('proveedor-id').value = p.id;
        document.getElementById('proveedor-nombre').value = p.nombre;
        document.getElementById('proveedor-email').value = p.email || '';
        document.getElementById('proveedor-direccion').value = p.direccion || '';
        
        // Lógica inteligente para separar el prefijo del teléfono
        let telefonoCompleto = p.telefono || '';
        let prefijo = '+503';
        let soloTelefono = '';

        if (telefonoCompleto) {
            if (telefonoCompleto.includes(' ')) {
                const partes = telefonoCompleto.split(' ');
                prefijo = partes[0];
                soloTelefono = partes.slice(1).join(' '); // Todo lo demás
            } else {
                soloTelefono = telefonoCompleto;
            }
        }
        
        document.getElementById('proveedor-prefijo').value = prefijo;
        document.getElementById('proveedor-telefono').value = soloTelefono;
        
        document.getElementById('proveedor-estado').value = p.estado_id || 1;
        document.getElementById('grupo-estado').style.display = 'block';
        
        document.getElementById('modal-titulo').innerText = 'Editar Proveedor #' + p.id;
        document.getElementById('modal-formulario').style.display = 'flex';
    }

    function cerrarModal() {
        document.getElementById('modal-formulario').style.display = 'none';
    }

    function abrirModalEliminar(id, nombre, contacto) {
        idAEliminar = id; 
        document.getElementById('eliminar-id-text').innerText = '#' + id;
        document.getElementById('eliminar-nombre-text').innerText = nombre;
        document.getElementById('eliminar-contacto-text').innerText = contacto;
        document.getElementById('modal-eliminar').style.display = 'flex';
    }

    function cerrarModalEliminar() {
        document.getElementById('modal-eliminar').style.display = 'none';
        idAEliminar = null; 
    }

    // Funciones CRUD con la API
    async function guardarRegistro(event) {
        event.preventDefault(); 
        const id = document.getElementById('proveedor-id').value;
        
        // Unimos el prefijo con el teléfono antes de mandarlo a la API
        const prefijo = document.getElementById('proveedor-prefijo').value.trim();
        const numTel = document.getElementById('proveedor-telefono').value.trim();
        const telefonoUnido = numTel ? `${prefijo} ${numTel}` : '';
        
        const payload = {
            nombre: document.getElementById('proveedor-nombre').value,
            telefono: telefonoUnido,
            email: document.getElementById('proveedor-email').value,
            direccion: document.getElementById('proveedor-direccion').value,
            estado_id: document.getElementById('proveedor-estado').value
        };

        const endpoint = id ? `${urlBase}/proveedores/actualizar` : `${urlBase}/proveedores/crear`;
        const metodo = id ? 'PUT' : 'POST';
        if (id) payload.id = id;

        try {
            const response = await fetch(endpoint, {
                method: metodo,
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (response.ok) {
                cerrarModal();
                mostrarToast(id ? 'Proveedor actualizado con éxito.' : 'Proveedor registrado exitosamente.', 'success');
                const res = await fetch(`${urlBase}/proveedores`);
                proveedoresCompletos = await res.json();
                filtrarDatos();
            } else {
                mostrarToast('Error al guardar. Verifique los datos ingresados.', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarToast('Ocurrió un error inesperado al procesar la solicitud.', 'error');
        }
    }

    async function confirmarEliminacion() {
        if (!idAEliminar) return;

        try {
            const response = await fetch(`${urlBase}/proveedores/eliminar/${idAEliminar}`, { method: 'DELETE' });
            if (response.ok) {
                cerrarModalEliminar();
                mostrarToast('El proveedor ha sido eliminado del directorio.', 'success');
                const res = await fetch(`${urlBase}/proveedores`);
                proveedoresCompletos = await res.json();
                filtrarDatos();
            } else {
                mostrarToast('No se pudo eliminar. Verifique que no esté asignado a ningún insumo.', 'error');
                cerrarModalEliminar();
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarToast('Error de red al intentar borrar el registro.', 'error');
        }
    }
</script>
@endsection