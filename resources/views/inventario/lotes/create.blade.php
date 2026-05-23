@extends('layouts.app')

@section('title', 'Registrar Nuevo Lote')

@section('content')
<div class="main-wrapper">
    <div class="form-container">

        <!-- Header -->
        <div class="form-header">
            <h3>
                <i class="bi bi-box-seam"></i> Nuevo Lote
            </h3>
            <p>Registro de inventario con control de trazabilidad</p>
        </div>

        <!-- Errores generales -->
        @if($errors->any())
            <div class="alert-custom">
                <strong>Error:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('inventario.lotes.store') }}" method="POST">
            @csrf

            <!-- Código de Lote -->
            <div class="form-group">
                <label>Código de Lote</label>
                <input type="text" name="codigo_lote" value="{{ old('codigo_lote') }}" placeholder="LOTE-2026-001" required>
            </div>

            <!-- Ubicación -->
            <div class="form-group">
                <label for="ubicacion_id">Ubicación</label>
                <select name="ubicacion_id" id="ubicacion_id">
                        <option value="">Seleccione una ubicación</option>
                        @foreach($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion->id }}" {{ old('ubicacion_id') == $ubicacion->id ? 'selected' : '' }}>
                                {{ $ubicacion->nombre }}
                            </option>
                        @endforeach
                </select>
                @error('ubicacion_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Insumo -->
            <div class="form-group">
                <label>Insumo</label>
                <select name="insumo_id" required>
                    <option value="" disabled selected>Seleccione un insumo</option>
                    @foreach($insumos as $insumo)
                        <option value="{{ $insumo->id }}">{{ $insumo->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Row -->
            <div class="form-row">
                <div class="form-group">
                    <label>Cantidad</label>
                    <input type="number" name="cantidad_inicial" min="1" required>
                </div>

                <div class="form-group">
                    <label>Vencimiento</label>
                    <input type="date" name="fecha_vencimiento" required>
                </div>
            </div>

            <!-- Proveedor -->
            <div class="form-group">
                <label>Proveedor</label>
                <select name="proveedor_id">
                    <option value="">Seleccione un proveedor</option>
                    @foreach ( $proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                        {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Botones -->
            <div class="form-actions">
                <a href="{{ route('inventario.lotes.index') }}" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-save">Guardar</button>
            </div>
        </form>

    </div>
</div>

<style>
/* Fondo general */
.main-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #eef2f7, #d9e2ec);
    padding: 20px;
}

/* Card principal */
.form-container {
    width: 100%;
    max-width: 500px;
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    animation: fadeIn 0.5s ease;
}

/* Header */
.form-header {
    text-align: center;
    margin-bottom: 25px;
}

.form-header h3 {
    font-weight: 700;
    color: #1e3c72;
}

.form-header p {
    font-size: 0.9rem;
    color: #6c757d;
}

/* Inputs */
.form-group {
    margin-bottom: 18px;
}

.form-group label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #495057;
    margin-bottom: 5px;
    display: block;
}

.form-group input,
.form-group select {
    width: 100%;
    border: none;
    border-bottom: 2px solid #dee2e6;
    padding: 8px;
    outline: none;
    transition: 0.3s;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #2a5298;
}

/* Mensajes de error por campo */
.error-message {
    font-size: 0.75rem;
    color: #dc3545;
    margin-top: 4px;
    display: block;
}

/* Row */
.form-row {
    display: flex;
    gap: 15px;
}

/* Botones */
.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 25px;
}

.btn-cancel {
    text-decoration: none;
    padding: 10px 18px;
    border-radius: 8px;
    background: #dee2e6;
    color: #333;
    transition: 0.3s;
}

.btn-cancel:hover {
    background: #ced4da;
}

.btn-save {
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: white;
    font-weight: 600;
    transition: 0.3s;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(42,82,152,0.3);
}

/* Alert */
.alert-custom {
    background: #ffe3e3;
    color: #842029;
    padding: 10px;
    border-radius: 10px;
    margin-bottom: 15px;
    font-size: 0.85rem;
}

/* Animación */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection