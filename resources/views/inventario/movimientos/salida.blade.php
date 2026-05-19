@extends('layouts.app')

@section('title', 'Registrar Salida')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-warning">
                <div class="card-header bg-warning">
                    <h4 class="mb-0"> Registrar Salida de Stock</h4>
                </div>
                <div class="card-body">

                    <div class="alert alert-info">
                        <strong>Lote:</strong> {{ $lote->codigo_lote }} |
                        <strong>Insumo:</strong> {{ $lote->insumo->nombre ?? 'N/A' }} |
                        <strong>Stock actual:</strong>
                        <span class="fw-bold {{ $lote->cantidad_actual <= 0 ? 'text-danger' : 'text-success' }}">
                            {{ $lote->cantidad_actual }}
                        </span>
                    </div>

                    @if($lote->estaVencido())
                        <div class="alert alert-danger">
                            Este lote está <strong>vencido</strong>. No se puede registrar salidas.
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('inventario.movimientos.store', $lote) }}" method="POST">
                        @csrf
                        <input type="hidden" name="tipo" value="salida">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Cantidad a retirar *</label>
                            <input type="number"
                                   name="cantidad"
                                   class="form-control @error('cantidad') is-invalid @enderror"
                                   value="{{ old('cantidad') }}"
                                   min="1"
                                   max="{{ $lote->cantidad_actual }}"
                                   required
                                   {{ $lote->estaVencido() ? 'disabled' : '' }}>
                            @error('cantidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Motivo</label>
                            <input type="text"
                                   name="motivo"
                                   class="form-control"
                                   value="{{ old('motivo') }}"
                                   placeholder="Ej: Consumo paciente"
                                   {{ $lote->estaVencido() ? 'disabled' : '' }}>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Referencia</label>
                            <input type="text"
                                   name="referencia"
                                   class="form-control"
                                   value="{{ old('referencia') }}"
                                   placeholder="Ej: Receta #456"
                                   {{ $lote->estaVencido() ? 'disabled' : '' }}>
                        </div>

                        <div class="d-flex gap-2">
                            @if(!$lote->estaVencido())
                                <button type="submit" class="btn btn-warning">Registrar Salida</button>
                            @endif
                            <a href="{{ route('inventario.lotes.show', $lote) }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection