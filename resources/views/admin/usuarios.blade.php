@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<style>
    /* DISEÑO BASE */
    .dashboard-premium { font-family: 'Inter', sans-serif; padding: 2.5rem 3.5rem; background-color: #f8fafc; min-height: 85vh; -webkit-font-smoothing: auto; }
    .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .title-wrapper h1 { font-size: 1.85rem; font-weight: 700; color: #0f172a; letter-spacing: -0.03em; margin: 0; }
    .title-wrapper p { color: #64748b; font-size: 0.95rem; margin: 0.3rem 0 0 0; }
    .btn-primary-custom { background-color: #0f172a; color: #ffffff; border: none; padding: 0.6rem 1.25rem; border-radius: 8px; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; transition: all 0.2s ease; }
    .btn-primary-custom:hover { background-color: #1e293b; transform: translateY(-1px); }
    .btn-secondary { background-color: #ffffff; color: #334155; border: 1px solid #e2e8f0; padding: 0.6rem 1rem; border-radius: 8px; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; gap: 0.4rem; cursor: pointer; }
    .toolbar { display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; gap: 1rem; }
    .search-box { position: relative; width: 350px; }
    .search-box i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 1.2rem; }
    .search-box input { width: 100%; padding: 0.6rem 1rem 0.6rem 2.8rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem; outline: none; }
    .table-card { background: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; overflow: hidden; }
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { background-color: #f8fafc; color: #1e293b; font-size: 0.75rem; text-transform: uppercase; font-weight: 800; padding: 1.2rem 1.5rem; text-align: left; border-bottom: 2px solid #e2e8f0; }
    .custom-table td { padding: 1.2rem 1.5rem; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
    .item-details strong { display: block; color: #000000 !important; font-size: 0.95rem; font-weight: 800 !important; line-height: 1.4; }
    .item-details span { color: #475569; font-size: 0.8rem; font-weight: 500; }
    .avatar { width: 42px; height: 42px; border-radius: 10px; background: #f1f5f9; color: #0f172a; display: flex; align-items: center; justify-content: center; font-weight: 800; border: 1.5px solid #e2e8f0; flex-shrink: 0; }
    .status-badge { display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.4rem 0.9rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 800; border: 1px solid transparent; }
    .status-badge i { font-size: 0.45rem; }
    .btn-icon { background: transparent; border: none; color: #94a3b8; width: 36px; height: 36px; font-size: 1.25rem; cursor: pointer; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; }
    .table-footer { padding: 1.5rem; background-color: #ffffff; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; color: #64748b; font-size: 0.875rem; }

    /* ESTILOS DE MODALES Y TOASTS */
    .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); justify-content: center; align-items: center; z-index: 1050; }
    .modal-content { background: #ffffff; padding: 2rem; border-radius: 12px; width: 100%; max-width: 500px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border: 1px solid #e2e8f0; max-height: 90vh; overflow-y: auto; }
    .modal-content h3 { margin-top: 0; color: #0f172a; font-weight: 800; font-size: 1.25rem; margin-bottom: 1.5rem; }
    .form-row { display: flex; gap: 1rem; }
    .form-group { margin-bottom: 1rem; width: 100%; }
    .form-group label { display: block; margin-bottom: 0.4rem; font-weight: 600; color: #475569; font-size: 0.85rem;}
    .form-group input, .form-group select { width: 100%; padding: 0.75rem 1rem; border: 1px solid #e2e8f0; border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 0.9rem; outline: none; transition: all 0.2s; box-sizing: border-box; }
    .form-group input:focus, .form-group select:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
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
            <h1>Gestión de Usuarios</h1>
            <p>Administración de accesos, cuentas de personal y roles del sistema.</p>
        </div>
        <button class="btn-primary-custom" onclick="abrirModalCrear()">
            <i class='bx bx-user-plus'></i> Registrar Usuario
        </button>
    </div>

    <div class="table-card">
        <div class="toolbar">
            <div class="search-box">
                <i class='bx bx-search'></i>
                <input type="text" id="inputBuscarUsuario" placeholder="Buscar..." oninput="filtrarDatos()">
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <div class="filter-wrapper">
                    <button class="btn-secondary" onclick="document.getElementById('filter-dropdown-usuarios').style.display = (document.getElementById('filter-dropdown-usuarios').style.display === 'block' ? 'none' : 'block')">
                        <i class='bx bx-filter-alt'></i> Filtro: <span id="filtro-actual">Todo</span>
                    </button>
                    <div id="filter-dropdown-usuarios" class="filter-dropdown">
                        <button onclick="setFiltro('todo', 'Todo')">Todo</button>
                        <button onclick="setFiltro('name', 'Usuario')">Usuario</button>
                        <button onclick="setFiltro('email', 'Correo')">Correo</button>
                        <button onclick="setFiltro('rol', 'Rol de Acceso')">Rol</button>
                        <button onclick="setFiltro('estado', 'Estado')">Estado</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 35%;">Usuario / Correo</th>
                    <th style="width: 25%;">Rol de Acceso</th>
                    <th style="width: 25%;">Estado de Cuenta</th>
                    <th style="width: 15%; text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody id="cuerpoTablaUsuarios">
                <tr><td colspan="4" style="text-align:center; padding:3rem; color: #64748b;">Cargando usuarios...</td></tr>
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
        <h3 id="modal-titulo">Registrar Usuario</h3>
        <form id="formulario-datos" onsubmit="guardarRegistro(event)">
            <input type="hidden" id="usuario-id">
            <div class="form-group"><label>Nombre Completo:</label><input type="text" id="usuario-nombre" required placeholder="Ej: Dr. Carlos Mendoza"></div>
            <div class="form-group"><label>Correo Electrónico:</label><input type="email" id="usuario-email" required placeholder="Ej: cmendoza@hospital.com"></div>
            <div class="form-group">
                <label>Contraseña de Acceso:</label>
                <input type="password" id="usuario-password" placeholder="Mínimo 8 caracteres">
                <span id="helper-password" style="font-size: 0.75rem; color: #94a3b8; display: none; margin-top: 4px;">Deja en blanco para conservar la contraseña actual.</span>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Rol Asignado:</label><select id="usuario-rol" required></select></div>
                <div class="form-group" id="grupo-estado">
                    <label>Estado Inicial:</label>
                    <select id="usuario-estado">
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                        <option value="3">Suspendido</option>
                    </select>
                </div>
            </div>
            <div class="modal-acciones">
                <button type="button" class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
                <button type="submit" class="btn-primary-custom" style="margin: 0; width: 100%; justify-content: center;">Guardar Usuario</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-eliminar" class="modal-overlay">
    <div class="modal-content">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <div style="width: 60px; height: 60px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto; font-size: 2rem;"><i class='bx bx-user-x'></i></div>
            <h3 style="margin-bottom: 0.5rem;">Confirmar Eliminación</h3>
            <p style="color: #64748b; font-size: 0.9rem; margin: 0;">¿Está seguro que desea revocar el acceso y borrar este usuario?</p>
        </div>
        <div style="background: #f8fafc; padding: 1.25rem; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 1.5rem;">
            <p style="margin: 0 0 0.5rem 0; font-size: 0.85rem; color: #64748b;"><strong>Nombre:</strong> <span id="eliminar-nombre-text" style="color: #0f172a; font-weight: 700;"></span></p>
            <p style="margin: 0; font-size: 0.85rem; color: #64748b;"><strong>Correo:</strong> <span id="eliminar-email-text"></span></p>
        </div>
        <div class="modal-acciones" style="display: flex; gap: 1rem; margin-top: 0;">
            <button type="button" class="btn-cancelar" onclick="cerrarModalEliminar()">Cancelar</button>
            <button type="button" onclick="confirmarEliminacion()" class="btn-danger-custom">Sí, Eliminar</button>
        </div>
    </div>
</div>

<script>
    const urlBase = '/api';
    const currentUserId = {{ Auth::id() }}; 
    let usuariosCompletos = [], usuariosFiltrados = [], rolesList = [];
    let paginaActual = 1, idAEliminar = null, filtroActivo = 'todo';
    const itemsPorPagina = 10;

    const estadosMap = {
        1: { texto: 'Activo', bg: '#ecfdf5', text: '#047857', border: '#10b981', icono: 'bxs-check-circle' },
        2: { texto: 'Inactivo', bg: '#f1f5f9', text: '#475569', border: '#cbd5e1', icono: 'bxs-minus-circle' },
        3: { texto: 'Suspendido', bg: '#fef2f2', text: '#b91c1c', border: '#fecaca', icono: 'bxs-error-circle' }
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
            const [usuariosRes, rolesRes] = await Promise.all([fetch(`${urlBase}/usuarios`), fetch(`${urlBase}/roles/obtener/todos`)]);
            usuariosCompletos = await usuariosRes.json();
            rolesList = await rolesRes.json();
            poblarRoles();
            filtrarDatos();
        } catch (error) {
            document.getElementById('cuerpoTablaUsuarios').innerHTML = `<tr><td colspan="4" style="text-align:center; padding:3rem; color:red;">Error de conexión con el servidor</td></tr>`;
            mostrarToast('No se pudieron cargar los datos del servidor.', 'error');
        }
    }

    function poblarRoles() {
        const selectRol = document.getElementById('usuario-rol');
        selectRol.innerHTML = '<option value="">Seleccione un rol...</option>';
        rolesList.forEach(r => { selectRol.innerHTML += `<option value="${r.id}">${r.nombre || r.name}</option>`; });
    }

    function setFiltro(tipo, nombre) {
        filtroActivo = tipo;
        document.getElementById('filtro-actual').innerText = nombre;
        document.getElementById('filter-dropdown-usuarios').style.display = 'none';
        filtrarDatos();
    }

    function filtrarDatos() {
        const termino = document.getElementById('inputBuscarUsuario').value.toLowerCase();
        
        usuariosFiltrados = usuariosCompletos.filter(u => {
            // Extraemos y mapeamos los textos reales
            const nombreUsuario = (u.name || '').toLowerCase();
            const emailUsuario = (u.email || '').toLowerCase();
            
            const rolObj = rolesList.find(r => r.id == u.role_id);
            const nombreRol = (rolObj ? (rolObj.nombre || rolObj.name) : 'sin rol').toLowerCase();
            
            const stateObj = estadosMap[u.estado_id || 1] || estadosMap[1];
            const nombreEstado = stateObj.texto.toLowerCase();

            // Lógica de filtrado
            if (filtroActivo === 'todo') {
                return nombreUsuario.includes(termino) || 
                    emailUsuario.includes(termino) || 
                    nombreRol.includes(termino) || 
                    nombreEstado.includes(termino);
            }
            if (filtroActivo === 'name') return nombreUsuario.includes(termino);
            if (filtroActivo === 'email') return emailUsuario.includes(termino);
            if (filtroActivo === 'rol') return nombreRol.includes(termino);
            if (filtroActivo === 'estado') return nombreEstado.includes(termino);
            
            return false;
        });
        
        paginaActual = 1; 
        renderizarTabla();
    }

    function renderizarTabla() {
        const tbody = document.getElementById('cuerpoTablaUsuarios');
        tbody.innerHTML = '';
        document.getElementById('contadorResultados').innerHTML = `Mostrando <strong>${usuariosFiltrados.length}</strong> cuentas`;

        if(usuariosFiltrados.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" style="text-align:center; padding:3rem; color: #64748b;">No se encontraron usuarios.</td></tr>`;
            actualizarBotonesPaginacion(); return;
        }

        const datosPagina = usuariosFiltrados.slice((paginaActual - 1) * itemsPorPagina, paginaActual * itemsPorPagina);

        datosPagina.forEach(u => {
            const iniciales = u.name ? u.name.split(' ').map(n=>n[0]).join('').substring(0,2).toUpperCase() : 'US';
            const rolObj = rolesList.find(r => r.id == u.role_id);
            const state = estadosMap[u.estado_id || 1] || estadosMap[1];
            const jsonItem = JSON.stringify(u).replace(/'/g, "&apos;").replace(/"/g, "&quot;");

            let accionesHtml = u.id === currentUserId 
                ? `<span style="background-color: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; border: 1px solid #e2e8f0;">Tu Cuenta</span>`
                : `<button class="btn-icon" onclick="abrirModalEditar('${jsonItem}')" onmouseover="this.style.backgroundColor='#f1f5f9'; this.style.color='#0f172a';" onmouseout="this.style.backgroundColor='transparent';"><i class='bx bx-edit-alt'></i></button>
                <button class="btn-icon" onclick="abrirModalEliminar(${u.id}, '${u.name}', '${u.email}')" onmouseover="this.style.color='#ef4444'; this.style.backgroundColor='#fee2e2';" onmouseout="this.style.color='#94a3b8'; this.style.backgroundColor='transparent';"><i class='bx bx-trash'></i></button>`;

            tbody.innerHTML += `
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div class="avatar">${iniciales}</div>
                            <div class="item-details"><strong>${u.name}</strong><span>${u.email}</span></div>
                        </div>
                    </td>
                    <td><div class="item-details"><strong>${rolObj ? (rolObj.nombre || rolObj.name) : 'Sin rol'}</strong><span>Permiso #${u.role_id}</span></div></td>
                    <td><div class="item-details"><span class="status-badge" style="background-color: ${state.bg} !important; color: ${state.text} !important; border-color: ${state.border} !important;"><i class='bx ${state.icono}'></i> ${state.texto}</span></div></td>
                    <td><div style="display: flex; justify-content: flex-end; align-items: center; gap: 5px;">${accionesHtml}</div></td>
                </tr>`;
        });
        actualizarBotonesPaginacion();
    }

    function actualizarBotonesPaginacion() {
        const totalPaginas = Math.ceil(usuariosFiltrados.length / itemsPorPagina) || 1;
        document.getElementById('btn-prev').disabled = (paginaActual === 1);
        document.getElementById('btn-next').disabled = (paginaActual === totalPaginas);
    }
    function cambiarPagina(dir) { paginaActual += dir; renderizarTabla(); }

    function abrirModalCrear() {
        document.getElementById('formulario-datos').reset();
        document.getElementById('usuario-id').value = '';
        document.getElementById('usuario-password').required = true;
        document.getElementById('helper-password').style.display = 'none';
        document.getElementById('grupo-estado').style.display = 'none';
        document.getElementById('modal-titulo').innerText = 'Registrar Usuario';
        document.getElementById('modal-formulario').style.display = 'flex';
    }

    function abrirModalEditar(itemString) {
        const u = JSON.parse(itemString.replace(/&quot;/g, '"').replace(/&apos;/g, "'"));
        document.getElementById('usuario-id').value = u.id;
        document.getElementById('usuario-nombre').value = u.name;
        document.getElementById('usuario-email').value = u.email;
        document.getElementById('usuario-rol').value = u.role_id || '';
        document.getElementById('usuario-estado').value = u.estado_id || 1;
        const inputPass = document.getElementById('usuario-password');
        inputPass.value = ''; inputPass.required = false;
        document.getElementById('helper-password').style.display = 'block';
        document.getElementById('grupo-estado').style.display = 'block';
        document.getElementById('modal-titulo').innerText = 'Editar Usuario #' + u.id;
        document.getElementById('modal-formulario').style.display = 'flex';
    }

    function cerrarModal() { document.getElementById('modal-formulario').style.display = 'none'; }
    function abrirModalEliminar(id, nom, email) { idAEliminar = id; document.getElementById('eliminar-nombre-text').innerText = nom; document.getElementById('eliminar-email-text').innerText = email; document.getElementById('modal-eliminar').style.display = 'flex'; }
    function cerrarModalEliminar() { document.getElementById('modal-eliminar').style.display = 'none'; idAEliminar = null; }

    async function guardarRegistro(e) {
        e.preventDefault(); const id = document.getElementById('usuario-id').value;
        const payload = { name: document.getElementById('usuario-nombre').value, email: document.getElementById('usuario-email').value, role_id: document.getElementById('usuario-rol').value, estado_id: document.getElementById('usuario-estado').value };
        if (id) payload.id = id;
        const pass = document.getElementById('usuario-password').value; 
        if (pass.trim() !== '') payload.password = pass;

        try {
            const res = await fetch(id ? `${urlBase}/usuarios/actualizar` : `${urlBase}/usuarios/crear`, { method: id ? 'PUT' : 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' }, body: JSON.stringify(payload) });
            const result = await res.json(); 
            if (res.ok) { cerrarModal(); mostrarToast(id ? 'Usuario actualizado correctamente.' : 'Usuario registrado con éxito.', 'success'); const r = await fetch(`${urlBase}/usuarios`); usuariosCompletos = await r.json(); filtrarDatos(); } 
            else { mostrarToast(result.message || 'Verifica los datos ingresados.', 'error'); }
        } catch(err) { mostrarToast('Ocurrió un error al intentar guardar los datos.', 'error'); }
    }

    async function confirmarEliminacion() {
        if (!idAEliminar) return;
        try {
            const res = await fetch(`${urlBase}/usuarios/eliminar/${idAEliminar}`, { method: 'DELETE' });
            const result = await res.json();
            if (res.ok) { cerrarModalEliminar(); mostrarToast('La cuenta de usuario ha sido eliminada.', 'success'); const r = await fetch(`${urlBase}/usuarios`); usuariosCompletos = await r.json(); filtrarDatos(); } 
            else { mostrarToast(result.message || 'No se pudo eliminar la cuenta.', 'error'); cerrarModalEliminar(); }
        } catch(err) { mostrarToast('Error de red al intentar borrar el registro.', 'error'); }
    }
</script>
@endsection