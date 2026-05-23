@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<style>
    .dashboard-premium { font-family: 'Inter', sans-serif; padding: 2.5rem 3.5rem; background-color: #f8fafc; min-height: 85vh; }
    .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .title-wrapper h1 { font-size: 1.85rem; font-weight: 700; color: #0f172a; margin: 0; }
    .btn-primary-custom { background-color: #0f172a; color: #ffffff; border: none; padding: 0.6rem 1.25rem; border-radius: 8px; font-weight: 500; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
    .btn-secondary { background-color: #ffffff; color: #334155; border: 1px solid #e2e8f0; padding: 0.6rem 1rem; border-radius: 8px; font-weight: 500; display: flex; align-items: center; gap: 0.4rem; cursor: pointer; }
    .toolbar { display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; gap: 1rem; }
    .search-box { position: relative; width: 350px; }
    .search-box i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 1.2rem;}
    .search-box input { width: 100%; padding: 0.6rem 1rem 0.6rem 2.8rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; }
    .table-card { background: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; overflow: hidden; }
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { background-color: #f8fafc; color: #1e293b; font-size: 0.75rem; text-transform: uppercase; font-weight: 800; padding: 1.2rem 1.5rem; text-align: left; border-bottom: 2px solid #e2e8f0; }
    .custom-table td { padding: 1.2rem 1.5rem; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
    .item-details strong { display: block; color: #000000 !important; font-size: 0.95rem; font-weight: 800 !important; line-height: 1.4; }
    .item-details span { color: #475569; font-size: 0.8rem; font-weight: 500; }
    .avatar { width: 42px; height: 42px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-weight: 800; border: 1.5px solid #dbeafe; }
    .status-badge { display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.4rem 0.9rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 800; border: 1px solid transparent; }
    .btn-icon { background: transparent; border: none; color: #94a3b8; width: 36px; height: 36px; font-size: 1.25rem; cursor: pointer; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; transition: 0.2s;}
    .btn-icon:hover { background-color: #f1f5f9; color: #0f172a; }
    .table-footer { padding: 1.5rem; background-color: #ffffff; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; color: #64748b; font-size: 0.875rem; }

    /* MODALES Y TOASTS */
    .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); justify-content: center; align-items: center; z-index: 1050; }
    .modal-content { background: #ffffff; padding: 2rem; border-radius: 12px; width: 100%; max-width: 500px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border: 1px solid #e2e8f0; max-height: 90vh; overflow-y: auto; }
    .modal-content h3 { margin-top: 0; color: #0f172a; font-weight: 800; font-size: 1.25rem; margin-bottom: 1.5rem; }
    .form-row { display: flex; gap: 1rem; }
    .form-group { margin-bottom: 1rem; width: 100%; }
    .form-group label { display: block; margin-bottom: 0.4rem; font-weight: 600; color: #475569; font-size: 0.85rem;}
    .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 0.75rem 1rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem; outline: none; box-sizing: border-box;}
    .modal-acciones { display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem; }
    .btn-cancelar { background-color: #f8fafc; color: #475569; border: 1px solid #e2e8f0; padding: 0.6rem 1.25rem; border-radius: 8px; font-weight: 600; cursor: pointer; width: 100%; text-align: center;}
    .btn-danger-custom { background-color: #ef4444; color: #ffffff; border: none; padding: 0.6rem 1.25rem; border-radius: 8px; font-weight: 600; cursor: pointer; width: 100%; text-align: center; }
    #toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; pointer-events: none; }
    .toast-custom { display: flex; align-items: center; gap: 12px; min-width: 280px; padding: 14px 18px; background-color: #ffffff; border-radius: 10px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border-left: 4px solid transparent; font-family: 'Inter', sans-serif; animation: slideIn 0.3s ease forwards; transition: opacity 0.3s ease; }
    .toast-success { border-left-color: #10b981; } .toast-error { border-left-color: #ef4444; }
    .toast-icon { font-size: 1.5rem; display: flex; align-items: center; }
    .toast-success .toast-icon { color: #10b981; } .toast-error .toast-icon { color: #ef4444; }
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
            <h1>Inventario de Insumos</h1>
            <p>Control de stock y suministros médicos de la farmacia.</p>
        </div>
        <button class="btn-primary-custom" onclick="abrirModalCrear()">
            <i class='bx bx-plus'></i> Registrar Insumo
        </button>
    </div>

    <div class="table-card">
        <div class="toolbar">
            <div class="search-box">
                <i class='bx bx-search'></i>
                <input type="text" id="inputBuscarInsumo" placeholder="Buscar..." oninput="filtrarDatos()">
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <div class="filter-wrapper">
                    <button class="btn-secondary" onclick="document.getElementById('filter-dropdown-insumos').style.display = (document.getElementById('filter-dropdown-insumos').style.display === 'block' ? 'none' : 'block')">
                        <i class='bx bx-filter-alt'></i> Filtro: <span id="filtro-actual">Todo</span>
                    </button>
                    <div id="filter-dropdown-insumos" class="filter-dropdown">
                        <button onclick="setFiltro('todo', 'Todo')">Todo</button>
                        <button onclick="setFiltro('nombre', 'Nombre')">Nombre</button>
                        <button onclick="setFiltro('codigo', 'Código')">Código</button>
                        <button onclick="setFiltro('descripcion', 'Descripción')">Descripción</button>
                        <button onclick="setFiltro('proveedor', 'Proveedor')">Proveedor</button>
                        <button onclick="setFiltro('categoria', 'Categoría')">Categoría</button>
                        <button onclick="setFiltro('estado', 'Estado')">Estado</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 25%;">Insumo / Código</th>
                    <th style="width: 25%;">Descripción / ID</th>
                    <th style="width: 20%;">Proveedor / Categoría</th>
                    <th style="width: 15%;">Stock / Estado</th>
                    <th style="width: 15%; text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody id="cuerpoTablaInsumos">
                <tr><td colspan="5" style="text-align:center; padding:3rem; color: #64748b;">Cargando inventario...</td></tr>
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
        <h3 id="modal-titulo">Registrar Insumo</h3>
        <form id="formulario-datos" onsubmit="guardarRegistro(event)">
            <input type="hidden" id="insumo-id">
            <div class="form-group"><label>Nombre del Insumo:</label><input type="text" id="insumo-nombre" required placeholder="Ej: Ibuprofeno 400mg"></div>
            <div class="form-row">
                <div class="form-group"><label>Código de Referencia:</label><input type="text" id="insumo-codigo" placeholder="Ej: MED-IBU-001"></div>
                <div class="form-group"><label>Stock Mínimo:</label><input type="number" id="insumo-stock" placeholder="Ej: 50" min="0"></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Proveedor:</label><select id="insumo-proveedor" required><option value="">Seleccione proveedor...</option></select></div>
                <div class="form-group"><label>Categoría:</label><select id="insumo-categoria"><option value="">Seleccione categoría...</option></select></div>
            </div>
            <div class="form-group"><label>Descripción / Presentación:</label><textarea id="insumo-descripcion" rows="2" placeholder="Caja con 20 tabletas..."></textarea></div>
            <div class="form-group" id="grupo-estado">
                <label>Estado del Insumo:</label>
                <select id="insumo-estado"><option value="1">Activo</option><option value="2">Inactivo</option><option value="3">En Cuarentena</option><option value="4">Agotado</option><option value="5">Descontinuado</option></select>
            </div>
            <div class="modal-acciones"><button type="button" class="btn-cancelar" onclick="cerrarModal()">Cancelar</button><button type="submit" class="btn-primary-custom" style="margin: 0; box-shadow: none; width: 100%; justify-content: center;">Guardar Insumo</button></div>
        </form>
    </div>
</div>

<div id="modal-eliminar" class="modal-overlay">
    <div class="modal-content">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <div style="width: 60px; height: 60px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto; font-size: 2rem;"><i class='bx bx-trash'></i></div>
            <h3 style="margin-bottom: 0.5rem; color: #1e293b;">Confirmar Eliminación</h3>
            <p style="color: #64748b; font-size: 0.9rem; margin: 0;">¿Está seguro que desea borrar este insumo del inventario?</p>
        </div>
        <div style="background: #f8fafc; padding: 1.25rem; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 1.5rem;">
            <p style="margin: 0 0 0.5rem 0; font-size: 0.85rem; color: #64748b;"><strong>ID del Insumo:</strong> <span id="eliminar-id-text"></span></p>
            <p style="margin: 0 0 0.5rem 0; font-size: 0.85rem; color: #64748b;"><strong>Nombre:</strong> <span id="eliminar-nombre-text" style="color: #0f172a; font-weight: 700; font-size: 0.95rem;"></span></p>
            <p style="margin: 0; font-size: 0.85rem; color: #64748b;"><strong>Código:</strong> <span id="eliminar-codigo-text"></span></p>
        </div>
        <div class="modal-acciones" style="display: flex; gap: 1rem; margin-top: 0;">
            <button type="button" class="btn-cancelar" onclick="cerrarModalEliminar()">Cancelar</button>
            <button type="button" onclick="confirmarEliminacion()" class="btn-danger-custom">Sí, Eliminar</button>
        </div>
    </div>
</div>

<script>
    const urlBase = '/api';
    let insumosCompletos = [], insumosFiltrados = [], proveedoresList = [], categoriasList = [];
    let paginaActual = 1, idAEliminar = null, filtroActivo = 'todo';
    const itemsPorPagina = 10;

    const estadosMap = {
        1: { texto: 'Activo', bg: '#ecfdf5', text: '#047857', border: '#10b981', icono: 'bxs-check-circle' },
        2: { texto: 'Inactivo', bg: '#f1f5f9', text: '#475569', border: '#cbd5e1', icono: 'bxs-minus-circle' },
        3: { texto: 'En Cuarentena', bg: '#fffbeb', text: '#b45309', border: '#fde68a', icono: 'bxs-error-circle' },
        4: { texto: 'Agotado', bg: '#fef2f2', text: '#b91c1c', border: '#fecaca', icono: 'bxs-x-circle' },
        5: { texto: 'Descontinuado', bg: '#f3f4f6', text: '#374151', border: '#d1d5db', icono: 'bxs-trash' }
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

    document.addEventListener('DOMContentLoaded', inicializar);

    async function inicializar() {
        try {
            const [insumosRes, provRes, catRes] = await Promise.all([fetch(`${urlBase}/insumos`), fetch(`${urlBase}/proveedores/obtener/todos`), fetch(`${urlBase}/categorias/obtener/todos`)]);
            insumosCompletos = await insumosRes.json(); proveedoresList = await provRes.json(); categoriasList = await catRes.json();
            poblarSelects(); filtrarDatos();
        } catch (error) {
            document.getElementById('cuerpoTablaInsumos').innerHTML = `<tr><td colspan="5" style="text-align:center; padding:3rem; color:red;">Error de conexión con la base de datos</td></tr>`;
            mostrarToast('No se pudieron cargar los datos del servidor.', 'error');
        }
    }

    function poblarSelects() {
        const selectProv = document.getElementById('insumo-proveedor'), selectCat = document.getElementById('insumo-categoria');
        proveedoresList.forEach(p => { selectProv.innerHTML += `<option value="${p.id}">${p.nombre}</option>`; });
        categoriasList.forEach(c => { selectCat.innerHTML += `<option value="${c.id}">${c.nombre}</option>`; });
    }

    function setFiltro(tipo, nombre) {
        filtroActivo = tipo;
        document.getElementById('filtro-actual').innerText = nombre;
        document.getElementById('filter-dropdown-insumos').style.display = 'none';
        filtrarDatos();
    }

    function filtrarDatos() {
        const termino = document.getElementById('inputBuscarInsumo').value.toLowerCase();
        
        insumosFiltrados = insumosCompletos.filter(i => {
            // Extraemos textos base
            const nombre = (i.nombre || '').toLowerCase();
            const codigo = (i.codigo || '').toLowerCase();
            const desc = (i.descripcion || '').toLowerCase();
            
            // Cruzamos datos para obtener textos reales de Proveedor, Categoría y Estado
            const prov = proveedoresList.find(p => p.id == i.proveedor_id);
            const nombreProv = (prov ? prov.nombre : '').toLowerCase();
            
            const cat = categoriasList.find(c => c.id == i.categoria_id);
            const nombreCat = (cat ? cat.nombre : '').toLowerCase();
            
            const stateObj = estadosMap[i.estado_id || 1] || estadosMap[1];
            const nombreEstado = stateObj.texto.toLowerCase();

            // Lógica de filtrado
            if (filtroActivo === 'todo') {
                return nombre.includes(termino) || 
                    codigo.includes(termino) || 
                    desc.includes(termino) ||
                    nombreProv.includes(termino) ||
                    nombreCat.includes(termino) ||
                    nombreEstado.includes(termino);
            }
            if (filtroActivo === 'nombre') return nombre.includes(termino);
            if (filtroActivo === 'codigo') return codigo.includes(termino);
            if (filtroActivo === 'descripcion') return desc.includes(termino);
            if (filtroActivo === 'proveedor') return nombreProv.includes(termino);
            if (filtroActivo === 'categoria') return nombreCat.includes(termino);
            if (filtroActivo === 'estado') return nombreEstado.includes(termino);
            
            return false;
        });
        
        paginaActual = 1; 
        renderizarTabla();
    }

    function renderizarTabla() {
        const tbody = document.getElementById('cuerpoTablaInsumos'); tbody.innerHTML = '';
        document.getElementById('contadorResultados').innerHTML = `Mostrando <strong>${insumosFiltrados.length}</strong> resultados`;

        if(insumosFiltrados.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" style="text-align:center; padding:3rem; color: #64748b;">No se encontraron insumos.</td></tr>`;
            actualizarBotonesPaginacion(); return;
        }

        const datosPagina = insumosFiltrados.slice((paginaActual - 1) * itemsPorPagina, paginaActual * itemsPorPagina);

        datosPagina.forEach(i => {
            const iniciales = i.nombre ? i.nombre.substring(0, 2).toUpperCase() : 'IN';
            const prov = proveedoresList.find(p => p.id == i.proveedor_id); const nombreProveedor = prov ? prov.nombre : 'Sin proveedor';
            const cat = categoriasList.find(c => c.id == i.categoria_id); const nombreCategoria = cat ? cat.nombre : 'Sin categoría';
            const state = estadosMap[i.estado_id || 1] || estadosMap[1];
            const jsonItem = JSON.stringify(i).replace(/'/g, "&apos;").replace(/"/g, "&quot;");

            tbody.innerHTML += `
                <tr>
                    <td><div style="display: flex; align-items: center; gap: 1rem;"><div class="avatar">${iniciales}</div><div class="item-details"><strong>${i.nombre}</strong><span>Ref: ${i.codigo || 'N/A'}</span></div></div></td>
                    <td><div class="item-details"><strong>${i.descripcion || 'Sin descripción'}</strong><span>Insumo ID: #${i.id}</span></div></td>
                    <td><div class="item-details"><strong>${nombreProveedor}</strong><span>Categoría: ${nombreCategoria}</span></div></td>
                    <td><div class="item-details"><strong>Mínimo: ${i.stock_minimo || 0}</strong><span class="status-badge" style="background-color: ${state.bg} !important; color: ${state.text} !important; border-color: ${state.border} !important; margin-top: 4px;"><i class='bx ${state.icono}' style="color: ${state.text} !important;"></i> ${state.texto}</span></div></td>
                    <td><div style="display: flex; justify-content: flex-end; gap: 5px;"><button class="btn-icon" onclick="abrirModalEditar('${jsonItem}')" onmouseover="this.style.backgroundColor='#f1f5f9'; this.style.color='#0f172a';" onmouseout="this.style.backgroundColor='transparent';"><i class='bx bx-edit-alt'></i></button><button class="btn-icon" onclick="abrirModalEliminar(${i.id}, '${i.nombre}', '${i.codigo || 'N/A'}')" onmouseover="this.style.color='#ef4444'; this.style.backgroundColor='#fee2e2';" onmouseout="this.style.color='#94a3b8'; this.style.backgroundColor='transparent';"><i class='bx bx-trash'></i></button></div></td>
                </tr>`;
        });
        actualizarBotonesPaginacion();
    }

    function actualizarBotonesPaginacion() {
        const totalPaginas = Math.ceil(insumosFiltrados.length / itemsPorPagina) || 1;
        document.getElementById('btn-prev').disabled = (paginaActual === 1);
        document.getElementById('btn-next').disabled = (paginaActual === totalPaginas);
    }
    function cambiarPagina(dir) { paginaActual += dir; renderizarTabla(); }

    function abrirModalCrear() {
        document.getElementById('formulario-datos').reset(); document.getElementById('insumo-id').value = '';
        document.getElementById('grupo-estado').style.display = 'none';
        document.getElementById('modal-titulo').innerText = 'Registrar Nuevo Insumo';
        document.getElementById('modal-formulario').style.display = 'flex';
    }

    function abrirModalEditar(itemString) {
        const i = JSON.parse(itemString.replace(/&quot;/g, '"').replace(/&apos;/g, "'"));
        document.getElementById('insumo-id').value = i.id; document.getElementById('insumo-nombre').value = i.nombre; document.getElementById('insumo-codigo').value = i.codigo || ''; document.getElementById('insumo-stock').value = i.stock_minimo || 0; document.getElementById('insumo-proveedor').value = i.proveedor_id || ''; document.getElementById('insumo-categoria').value = i.categoria_id || ''; document.getElementById('insumo-descripcion').value = i.descripcion || ''; document.getElementById('insumo-estado').value = i.estado_id || 1;
        document.getElementById('grupo-estado').style.display = 'block';
        document.getElementById('modal-titulo').innerText = 'Editar Insumo #' + i.id;
        document.getElementById('modal-formulario').style.display = 'flex';
    }

    function cerrarModal() { document.getElementById('modal-formulario').style.display = 'none'; }
    function abrirModalEliminar(id, nom, cod) { idAEliminar = id; document.getElementById('eliminar-id-text').innerText = '#' + id; document.getElementById('eliminar-nombre-text').innerText = nom; document.getElementById('eliminar-codigo-text').innerText = cod; document.getElementById('modal-eliminar').style.display = 'flex'; }
    function cerrarModalEliminar() { document.getElementById('modal-eliminar').style.display = 'none'; idAEliminar = null; }

    async function guardarRegistro(e) {
        e.preventDefault(); const id = document.getElementById('insumo-id').value;
        const payload = { nombre: document.getElementById('insumo-nombre').value, codigo: document.getElementById('insumo-codigo').value, stock_minimo: parseInt(document.getElementById('insumo-stock').value) || 0, proveedor_id: document.getElementById('insumo-proveedor').value, categoria_id: document.getElementById('insumo-categoria').value, descripcion: document.getElementById('insumo-descripcion').value, estado_id: document.getElementById('insumo-estado').value };
        if(id) payload.id = id;

        try {
            const res = await fetch(id ? `${urlBase}/insumos/actualizar` : `${urlBase}/insumos/crear`, { method: id ? 'PUT' : 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' }, body: JSON.stringify(payload) });
            if (res.ok) { cerrarModal(); mostrarToast(id ? 'Insumo actualizado correctamente.' : 'Insumo registrado con éxito.', 'success'); const r = await fetch(`${urlBase}/insumos`); insumosCompletos = await r.json(); filtrarDatos(); } 
            else { mostrarToast('Error al guardar. Verifique los datos o que el proveedor exista.', 'error'); }
        } catch (err) { mostrarToast('Ocurrió un error inesperado.', 'error'); }
    }

    async function confirmarEliminacion() {
        if(!idAEliminar) return;
        try {
            const res = await fetch(`${urlBase}/insumos/eliminar/${idAEliminar}`, { method: 'DELETE' });
            if (res.ok) { cerrarModalEliminar(); mostrarToast('Insumo eliminado de la base de datos.', 'success'); const r = await fetch(`${urlBase}/insumos`); insumosCompletos = await r.json(); filtrarDatos(); } 
            else { mostrarToast('No se pudo eliminar el insumo. Verifique que no esté en uso.', 'error'); cerrarModalEliminar(); }
        } catch (err) { mostrarToast('Error de red al intentar borrar el registro.', 'error'); }
    }
</script>
@endsection