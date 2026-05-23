@extends('layouts.app')

@section('title', 'Configuraciones - Farmacia Hospitalaria')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<style>
    /* estilos base */
    .dashboard-premium { font-family: 'Inter', sans-serif; padding: 2.5rem 3.5rem; background-color: #f8fafc; min-height: 85vh; -webkit-font-smoothing: auto; }
    .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .title-wrapper h1 { font-size: 1.85rem; font-weight: 700; color: #0f172a; letter-spacing: -0.03em; margin: 0; }
    .title-wrapper p { color: #64748b; font-size: 0.95rem; margin: 0.3rem 0 0 0; }
    .btn-primary-custom { background-color: #0f172a; color: #ffffff; border: none; padding: 0.6rem 1.25rem; border-radius: 8px; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
    .btn-primary-custom:hover { background-color: #1e293b; transform: translateY(-1px); }
    .btn-secondary { background-color: #ffffff; color: #334155; border: 1px solid #e2e8f0; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 0.4rem; cursor: pointer; transition: 0.2s; }
    .btn-secondary:hover:not(:disabled) { background-color: #f8fafc; }
    .btn-secondary:disabled { opacity: 0.5; cursor: not-allowed; }
    .tabs-premium { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; background: #ffffff; padding: 0.5rem; border-radius: 10px; border: 1px solid #e2e8f0; width: fit-content; box-shadow: 0 2px 4px -1px rgba(0,0,0,0.03); }
    .tab-btn { background-color: transparent; color: #64748b; border: none; padding: 0.6rem 1.25rem; border-radius: 6px; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; gap: 0.4rem; }
    .tab-btn:hover { background-color: #f1f5f9; color: #0f172a; }
    .tab-btn.active { background-color: #eff6ff; color: #2563eb; }
    .table-card { background: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; overflow: hidden; }
    .toolbar { display: flex; justify-content: space-between; align-items: center; padding: 1.2rem 1.5rem; border-bottom: 1px solid #e2e8f0;}
    .search-box { position: relative; width: 320px; }
    .search-box i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 1.2rem; }
    .search-box input { width: 100%; padding: 0.55rem 1rem 0.55rem 2.8rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem; outline: none; transition: 0.2s; box-sizing: border-box; }
    .search-box input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { background-color: #f8fafc; color: #1e293b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 800; padding: 1.2rem 1.5rem; text-align: left; border-bottom: 2px solid #e2e8f0; }
    .custom-table td { padding: 1.2rem 1.5rem; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
    .provider-details strong { display: block; color: #000000 !important; font-size: 0.95rem; font-weight: 800 !important; line-height: 1.4; margin-bottom: 2px; }
    .provider-details span { color: #475569; font-size: 0.8rem; font-weight: 500; }
    .provider-identity { display: flex; align-items: center; gap: 1rem; }
    .avatar { width: 42px; height: 42px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.95rem; border: 1.5px solid #dbeafe; flex-shrink: 0; }
    .badge { display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.3rem 0.8rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; border: 1px solid transparent; }
    .badge-1 { background-color: #ecfdf5; color: #047857; border-color: #a7f3d0; } 
    .badge-2 { background-color: #f1f5f9; color: #475569; border-color: #cbd5e1; } 
    .badge-3 { background-color: #fffbeb; color: #b45309; border-color: #fde68a; } 
    .badge-4 { background-color: #fef2f2; color: #b91c1c; border-color: #fecaca; } 
    .badge-5 { background-color: #f3f4f6; color: #374151; border-color: #d1d5db; } 
    .btn-icon { background: transparent; border: none; color: #94a3b8; width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; font-size: 1.25rem; }
    .btn-icon:hover { background-color: #f1f5f9; color: #0f172a; }
    .btn-icon.delete:hover { background-color: #fef2f2; color: #ef4444; }
    .table-footer { padding: 1rem 1.5rem; background-color: #ffffff; display: flex; justify-content: space-between; align-items: center; color: #64748b; font-size: 0.875rem; font-weight: 500; }

    /* ESTILOS DE MODALES Y TOASTS */
    .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); justify-content: center; align-items: center; z-index: 1050; }
    .modal-content { background: #ffffff; padding: 2rem; border-radius: 12px; width: 100%; max-width: 450px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border: 1px solid #e2e8f0; }
    .modal-content h3 { margin-top: 0; color: #0f172a; font-weight: 800; font-size: 1.25rem; margin-bottom: 1.5rem; }
    .form-group { margin-bottom: 1rem; }
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
            <h1>Centro de Mando de Infraestructura</h1>
            <p>Gestión centralizada de catálogos y parámetros del sistema.</p>
        </div>
        <button class="btn-primary-custom" onclick="abrirModalCrear()">
            <i class='bx bx-plus'></i> <span id="btn-text">Nueva Categoría</span>
        </button>
    </div>

    <div class="tabs-premium">
        <button id="tab-categorias" class="tab-btn active" onclick="cambiarModulo('categorias', 'Categoría', 'Nueva Categoría')">Categorías</button>
        <button id="tab-areas" class="tab-btn" onclick="cambiarModulo('areas', 'Área', 'Nueva Área')">Áreas</button>
        <button id="tab-ubicaciones" class="tab-btn" onclick="cambiarModulo('ubicaciones', 'Ubicación', 'Nueva Ubicación')">Ubicaciones</button>
        <button id="tab-estados" class="tab-btn" onclick="cambiarModulo('estados', 'Estado', 'Nuevo Estado')">Estados</button>
    </div>

    <div class="table-card">
        <div class="toolbar">
            <div class="search-box">
                <i class='bx bx-search'></i>
                <input type="text" id="inputBuscar" placeholder="Buscar registro..." oninput="filtrarDatos()">
            </div>
            
            <div style="display: flex; gap: 0.75rem; align-items: center;">
                <div class="filter-wrapper">
                    <button class="btn-secondary" onclick="document.getElementById('filter-dropdown-config').style.display = (document.getElementById('filter-dropdown-config').style.display === 'block' ? 'none' : 'block')">
                        <i class='bx bx-filter-alt'></i> Filtro: <span id="filtro-actual">Todo</span>
                    </button>
                    <div id="filter-dropdown-config" class="filter-dropdown">
                        <button onclick="setFiltro('todo', 'Todo')">🔍 Todo</button>
                        <button onclick="setFiltro('id', 'ID')">#️⃣ ID</button>
                        <button onclick="setFiltro('nombre', 'Nombre')">📝 Nombre</button>
                        <button onclick="setFiltro('descripcion', 'Descripción')">📖 Descripción</button>
                    </div>
                </div>
                <div id="info-registros" style="color: #64748b; font-size: 0.85rem; font-weight: 600;">0 registros encontrados</div>
            </div>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 35%;">Información del Registro</th>
                    <th style="width: 35%;" id="th-descripcion">Detalles / Descripción</th>
                    <th style="width: 15%;" id="th-estado">Estado</th>
                    <th style="width: 15%; text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-cuerpo">
                <tr><td colspan="4" style="text-align:center; padding:3rem; color: #64748b;">Cargando datos...</td></tr>
            </tbody>
        </table>

        <div class="table-footer">
            <span id="texto-paginacion">Página 1 de 1</span>
            <div style="display: flex; gap: 0.5rem;">
                <button class="btn-secondary" id="btn-prev" onclick="cambiarPagina(-1)">Anterior</button>
                <button class="btn-secondary" id="btn-next" onclick="cambiarPagina(1)">Siguiente</button>
            </div>
        </div>
    </div>
</div>

<div id="modal-formulario" class="modal-overlay">
    <div class="modal-content">
        <h3 id="modal-titulo">Crear Registro</h3>
        <form id="formulario-datos" onsubmit="guardarRegistro(event)">
            <input type="hidden" id="registro-id">
            <div class="form-group"><label>Nombre del Registro:</label><input type="text" id="registro-nombre" required></div>
            <div class="form-group" id="grupo-descripcion"><label>Descripción / Observaciones:</label><textarea id="registro-descripcion" rows="3"></textarea></div>
            <div class="form-group" id="grupo-estado">
                <label>Estado Inicial:</label>
                <select id="registro-estado"><option value="1">Activo</option><option value="2">Inactivo</option><option value="3">En Cuarentena</option><option value="4">Agotado</option><option value="5">Descontinuado</option></select>
            </div>
            <div class="modal-acciones"><button type="button" class="btn-cancelar" onclick="cerrarModal()">Cancelar</button><button type="submit" class="btn-primary-custom" style="margin: 0; box-shadow: none; width: 100%; justify-content: center;">Guardar Datos</button></div>
        </form>
    </div>
</div>

<div id="modal-eliminar" class="modal-overlay">
    <div class="modal-content">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <div style="width: 60px; height: 60px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto; font-size: 2rem;"><i class='bx bx-trash'></i></div>
            <h3 id="modal-eliminar-titulo" style="margin-bottom: 0.5rem; color: #1e293b;">Confirmar Eliminación</h3>
            <p style="color: #64748b; font-size: 0.9rem; margin: 0;">¿Está seguro que desea borrar este registro del sistema?</p>
        </div>
        <div style="background: #f8fafc; padding: 1.25rem; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 1.5rem;">
            <p style="margin: 0 0 0.5rem 0; font-size: 0.85rem; color: #64748b;"><strong>ID del Registro:</strong> <span id="eliminar-id-text"></span></p>
            <p style="margin: 0 0 0.5rem 0; font-size: 0.85rem; color: #64748b;"><strong>Nombre:</strong> <span id="eliminar-nombre-text" style="color: #0f172a; font-weight: 700; font-size: 0.95rem;"></span></p>
            <p id="eliminar-desc-container" style="margin: 0; font-size: 0.85rem; color: #64748b;"><strong>Descripción:</strong> <span id="eliminar-desc-text"></span></p>
        </div>
        <div class="modal-acciones" style="display: flex; gap: 1rem; margin-top: 0;">
            <button type="button" class="btn-cancelar" onclick="cerrarModalEliminar()">Cancelar</button>
            <button type="button" onclick="confirmarEliminacion()" class="btn-danger-custom">Sí, Eliminar</button>
        </div>
    </div>
</div>

<script>
    const urlBase = '/api'; 
    let moduloActual = 'categorias', moduloSingular = 'Categoría'; 
    let datosCompletos = [], datosFiltrados = [];
    let paginaActual = 1, idAEliminar = null, filtroActivo = 'todo';
    const itemsPorPagina = 10;

    const estadosMap = {
        1: { texto: 'Activo', clase: 'badge-1', icono: 'bxs-check-circle' },
        2: { texto: 'Inactivo', clase: 'badge-2', icono: 'bxs-minus-circle' },
        3: { texto: 'En Cuarentena', clase: 'badge-3', icono: 'bxs-error-circle' },
        4: { texto: 'Agotado', clase: 'badge-4', icono: 'bxs-x-circle' },
        5: { texto: 'Descontinuado', clase: 'badge-5', icono: 'bxs-trash' }
    };

    function mostrarToast(mensaje, tipo = 'success') {
        const contenedor = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `toast-custom toast-${tipo}`;
        const icono = tipo === 'success' ? 'bx-check-circle' : 'bx-error-circle';
        const titulo = tipo === 'success' ? '¡Operación Exitosa!' : 'Atención';
        toast.innerHTML = `<div class="toast-icon"><i class='bx ${icono}'></i></div><div class="toast-content"><span class="toast-title">${titulo}</span><span class="toast-message">${mensaje}</span></div>`;
        contenedor.appendChild(toast);
        setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3500);
    }

    function cambiarModulo(modulo, singular, textBoton) {
        moduloActual = modulo; moduloSingular = singular; 
        document.getElementById('btn-text').innerText = textBoton;
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.getElementById('tab-' + modulo).classList.add('active');
        document.getElementById('inputBuscar').value = ''; 
        const esModuloEstado = (modulo === 'estados');
        document.getElementById('grupo-descripcion').style.display = esModuloEstado ? 'none' : 'block';
        document.getElementById('th-descripcion').style.display = esModuloEstado ? 'none' : 'table-cell';
        document.getElementById('th-estado').style.display = esModuloEstado ? 'none' : 'table-cell';
        cargarDatosDesdeAPI();
    }

    async function cargarDatosDesdeAPI() {
        const tbody = document.getElementById('tabla-cuerpo');
        const esModuloEstado = (moduloActual === 'estados');
        tbody.innerHTML = `<tr><td colspan="${esModuloEstado ? 2 : 4}" style="text-align:center; padding:3rem;">Cargando datos...</td></tr>`;
        try {
            const response = await fetch(`${urlBase}/${moduloActual}/obtener/todos`);
            datosCompletos = await response.json();
            filtrarDatos(); 
        } catch (error) {
            tbody.innerHTML = `<tr><td colspan="${esModuloEstado ? 2 : 4}" style="text-align:center; color:red;">Error de conexión con el servidor</td></tr>`;
            mostrarToast('No se pudieron cargar los datos.', 'error');
        }
    }

    function setFiltro(tipo, nombre) {
        filtroActivo = tipo;
        document.getElementById('filtro-actual').innerText = nombre;
        document.getElementById('filter-dropdown-config').style.display = 'none';
        filtrarDatos();
    }

    function filtrarDatos() {
        const termino = document.getElementById('inputBuscar').value.toLowerCase();
        datosFiltrados = datosCompletos.filter(item => {
            if (filtroActivo === 'todo') {
                return (item.nombre || '').toLowerCase().includes(termino) || 
                    (item.descripcion || '').toLowerCase().includes(termino) || 
                    item.id.toString().includes(termino);
            }
            if (filtroActivo === 'id') return item.id.toString().includes(termino);
            return (item[filtroActivo] || '').toLowerCase().includes(termino);
        });
        paginaActual = 1; renderizarTabla();
    }

    function renderizarTabla() {
        const tbody = document.getElementById('tabla-cuerpo');
        const esModuloEstado = (moduloActual === 'estados');
        tbody.innerHTML = '';
        document.getElementById('info-registros').innerText = `${datosFiltrados.length} registros`;

        if(datosFiltrados.length === 0) {
            tbody.innerHTML = `<tr><td colspan="${esModuloEstado ? 2 : 4}" style="text-align:center; padding:3rem;">No hay registros para mostrar.</td></tr>`;
            actualizarBotonesPaginacion(); return;
        }

        const datosPagina = datosFiltrados.slice((paginaActual - 1) * itemsPorPagina, paginaActual * itemsPorPagina);

        datosPagina.forEach(item => {
            const desc = item.descripcion ? item.descripcion.replace(/"/g, '&quot;') : '';
            const nom = item.nombre.replace(/"/g, '&quot;');
            const iniciales = item.nombre ? item.nombre.substring(0, 2).toUpperCase() : 'NA';
            const estadoId = item.estado_id || 1; 
            const infoEstado = estadosMap[estadoId] || estadosMap[1];

            let fila = `<tr><td><div class="provider-identity"><div class="avatar">${iniciales}</div><div class="provider-details"><strong>${item.nombre}</strong><span>Código ID: #${item.id}</span></div></div></td>`;
            if(!esModuloEstado) { fila += `<td><div class="provider-details"><strong>${item.descripcion || 'Sin descripción'}</strong><span>Detalles</span></div></td><td><span class="badge ${infoEstado.clase}"><i class='bx ${infoEstado.icono}'></i> ${infoEstado.texto}</span></td>`; }
            fila += `<td><div style="display: flex; justify-content: flex-end; gap: 5px;"><button class="btn-icon" onclick="abrirModalEditar(${item.id}, '${nom}', '${desc}', ${estadoId})"><i class='bx bx-edit-alt'></i></button><button class="btn-icon delete" onclick="abrirModalEliminar(${item.id}, '${nom}', '${desc}')"><i class='bx bx-trash'></i></button></div></td></tr>`;
            tbody.innerHTML += fila;
        });
        actualizarBotonesPaginacion();
    }

    function actualizarBotonesPaginacion() {
        const totalPaginas = Math.ceil(datosFiltrados.length / itemsPorPagina) || 1;
        document.getElementById('texto-paginacion').innerText = `Página ${paginaActual} de ${totalPaginas}`;
        document.getElementById('btn-prev').disabled = (paginaActual === 1);
        document.getElementById('btn-next').disabled = (paginaActual === totalPaginas);
    }
    function cambiarPagina(dir) { paginaActual += dir; renderizarTabla(); }

    function abrirModalCrear() {
        document.getElementById('formulario-datos').reset();
        document.getElementById('registro-id').value = '';
        document.getElementById('grupo-estado').style.display = 'none';
        document.getElementById('modal-titulo').innerText = 'Crear Nueva ' + moduloSingular;
        document.getElementById('modal-formulario').style.display = 'flex';
    }

    function abrirModalEditar(id, nombre, descripcion, estado_id) {
        document.getElementById('registro-id').value = id; document.getElementById('registro-nombre').value = nombre; document.getElementById('registro-descripcion').value = descripcion; document.getElementById('registro-estado').value = estado_id || 1;
        document.getElementById('grupo-estado').style.display = (moduloActual === 'estados') ? 'none' : 'block';
        document.getElementById('modal-titulo').innerText = 'Editar ' + moduloSingular + ' #' + id;
        document.getElementById('modal-formulario').style.display = 'flex';
    }

    function cerrarModal() { document.getElementById('modal-formulario').style.display = 'none'; }
    function abrirModalEliminar(id, nombre, descripcion) { idAEliminar = id; document.getElementById('modal-eliminar-titulo').innerText = 'Eliminar ' + moduloSingular; document.getElementById('eliminar-id-text').innerText = '#' + id; document.getElementById('eliminar-nombre-text').innerText = nombre; if (moduloActual === 'estados') { document.getElementById('eliminar-desc-container').style.display = 'none'; } else { document.getElementById('eliminar-desc-container').style.display = 'block'; document.getElementById('eliminar-desc-text').innerText = descripcion || 'Sin descripción'; } document.getElementById('modal-eliminar').style.display = 'flex'; }
    function cerrarModalEliminar() { document.getElementById('modal-eliminar').style.display = 'none'; idAEliminar = null; }

    async function guardarRegistro(e) {
        e.preventDefault(); const id = document.getElementById('registro-id').value;
        const payload = { nombre: document.getElementById('registro-nombre').value };
        if (moduloActual !== 'estados') { payload.descripcion = document.getElementById('registro-descripcion').value; payload.estado_id = document.getElementById('registro-estado').value; }
        try {
            const response = await fetch(id ? `${urlBase}/${moduloActual}/actualizar` : `${urlBase}/${moduloActual}/crear`, { method: id ? 'PUT' : 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' }, body: JSON.stringify({...payload, id: id || undefined}) });
            if (response.ok) { cerrarModal(); mostrarToast(id ? `${moduloSingular} actualizado con éxito.` : `${moduloSingular} registrado correctamente.`, 'success'); cargarDatosDesdeAPI(); } 
            else { mostrarToast('Error al guardar. Verifique los datos o posibles duplicados.', 'error'); }
        } catch (error) { mostrarToast('Ocurrió un error inesperado.', 'error'); }
    }

    async function confirmarEliminacion() {
        if(!idAEliminar) return;
        try {
            const response = await fetch(`${urlBase}/${moduloActual}/eliminar/${idAEliminar}`, { method: 'DELETE' });
            if (response.ok) { cerrarModalEliminar(); mostrarToast(`${moduloSingular} eliminado exitosamente.`, 'success'); cargarDatosDesdeAPI(); } 
            else { mostrarToast('No se pudo eliminar. Verifique dependencias.', 'error'); cerrarModalEliminar(); }
        } catch (error) { mostrarToast('Error de red al intentar borrar.', 'error'); }
    }

    document.addEventListener('DOMContentLoaded', () => { cambiarModulo('categorias', 'Categoría', 'Nueva Categoría'); });
</script>
@endsection