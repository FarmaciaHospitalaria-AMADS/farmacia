@extends('layouts.app')

@section('title', 'Registrar Entrada')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-success">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"> Registrar Entrada de Stock</h4>
                </div>
                <div class="card-body">

                    <div class="alert alert-info">
                        <strong>Lote:</strong> {{ $lote->codigo_lote }} |
                        <strong>Insumo:</strong> {{ $lote->insumo->nombre ?? 'N/A' }} |
                        <strong>Stock actual:</strong> {{ $lote->cantidad_actual }}
                    </div>

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
                        <input type="hidden" name="tipo" value="entrada">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Cantidad a ingresar *</label>
                            <input type="number"
                                   name="cantidad"
                                   class="form-control @error('cantidad') is-invalid @enderror"
                                   value="{{ old('cantidad') }}"
                                   min="1"
                                   required>
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
                                   placeholder="Ej: Reposición de stock">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Referencia</label>
                            <input type="text"
                                   name="referencia"
                                   class="form-control"
                                   value="{{ old('referencia') }}"
                                   placeholder="Ej: Orden de compra #123">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">Registrar Entrada</button>
                            <a href="{{ route('inventario.lotes.show', $lote) }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection