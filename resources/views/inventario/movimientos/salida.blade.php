@extends('layouts.app')

@section('title', 'Registrar Salida')

@section('content')
<style>

.main-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #eef2f7, #d9e2ec);
    padding: 20px;
}

.form-container {
    width: 100%;
    max-width: 500px;
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    animation: fadeIn 0.5s ease;
}

.form-header {
    text-align: center;
    margin-bottom: 25px;
}

.form-header h3 {
    font-weight: 700;
    color: #842029;
    margin: 0;
}

.form-header p {
    font-size: 0.9rem;
    color: #6c757d;
    margin: 4px 0 0;
}

/* Info del lote */
.lote-info {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    background: #f1f5f9;
    border-radius: 10px;
    padding: 12px 15px;
    margin-bottom: 22px;
    font-size: 0.85rem;
    color: #495057;
}

.lote-info span { display: flex; gap: 4px; }
.lote-info strong { color: #1e3c72; }
.stock-ok   { color: #198754; font-weight: 700; }
.stock-zero { color: #dc3545; font-weight: 700; }

/* Alerta vencido */
.alert-vencido {
    background: #f8d7da;
    color: #842029;
    padding: 10px 14px;
    border-radius: 10px;
    margin-bottom: 18px;
    font-size: 0.85rem;
    text-align: center;
}

/* Inputs */
.form-group { margin-bottom: 18px; }

.form-group label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #495057;
    margin-bottom: 5px;
    display: block;
}

.form-group input {
    width: 100%;
    border: none;
    border-bottom: 2px solid #dee2e6;
    padding: 8px;
    outline: none;
    transition: 0.3s;
    font-size: 0.9rem;
    background: transparent;
}

.form-group input:focus { border-color: #dc3545; }
.form-group input:disabled { opacity: 0.5; cursor: not-allowed; }
.input-error { border-color: #dc3545 !important; }

.error-msg {
    font-size: 0.78rem;
    color: #dc3545;
    margin-top: 4px;
}

/* Alert error */
.alert-custom {
    background: #ffe3e3;
    color: #842029;
    padding: 10px 14px;
    border-radius: 10px;
    margin-bottom: 18px;
    font-size: 0.85rem;
}

.alert-custom ul { margin: 4px 0 0; padding-left: 18px; }

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

.btn-cancel:hover { background: #ced4da; color: #333; }

.btn-save {
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    background: linear-gradient(135deg, #dc3545, #b02a37);
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(220,53,69,0.3);
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to   { opacity: 1; transform: translateY(0); }
}

</style>

<div class="main-wrapper">
<div class="form-container">

    {{-- Header --}}
    <div class="form-header">
        <h3>➖ Registrar Salida</h3>
        <p>Retiro de stock del inventario</p>
    </div>

    {{-- Info del lote --}}
    <div class="lote-info">
        <span><strong>Lote:</strong> {{ $lote->codigo_lote }}</span>
        <span>·</span>
        <span><strong>Insumo:</strong> {{ $lote->insumo->nombre ?? 'N/A' }}</span>
        <span>·</span>
        <span>
            <strong>Stock:</strong>
            <em class="{{ $lote->cantidad_actual <= 0 ? 'stock-zero' : 'stock-ok' }}">
                {{ $lote->cantidad_actual }}
            </em>
        </span>
    </div>

    {{-- Alerta vencido --}}
    @if($lote->estaVencido())
        <div class="alert-vencido">
            ⚠️ Este lote está <strong>vencido</strong>. No se pueden registrar salidas.
        </div>
    @endif

    {{-- Errores --}}
    @if($errors->any())
        <div class="alert-custom">
            <strong>Corrige los siguientes errores:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario --}}
    <form action="{{ route('inventario.movimientos.store', $lote) }}" method="POST">
        @csrf
        <input type="hidden" name="tipo" value="salida">

        <div class="form-group">
            <label>Cantidad a retirar *</label>
            <input
                type="number"
                name="cantidad"
                value="{{ old('cantidad') }}"
                min="1"
                max="{{ $lote->cantidad_actual }}"
                placeholder="Máx: {{ $lote->cantidad_actual }}"
                class="{{ $errors->has('cantidad') ? 'input-error' : '' }}"
                {{ $lote->estaVencido() ? 'disabled' : '' }}
                required
            >
            @error('cantidad')
                <div class="error-msg">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Motivo</label>
            <input
                type="text"
                name="motivo"
                value="{{ old('motivo') }}"
                placeholder="Ej: Consumo paciente"
                {{ $lote->estaVencido() ? 'disabled' : '' }}
            >
        </div>

        <div class="form-group">
            <label>Referencia</label>
            <input
                type="text"
                name="referencia"
                value="{{ old('referencia') }}"
                placeholder="Ej: Receta #456"
                {{ $lote->estaVencido() ? 'disabled' : '' }}
            >
        </div>

        <div class="form-actions">
            <a href="{{ route('inventario.lotes.show', $lote) }}" class="btn-cancel">Cancelar</a>
            @if(!$lote->estaVencido())
                <button type="submit" class="btn-save">Guardar Salida</button>
            @endif
        </div>
    </form>

</div>
</div>

@endsection