<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insumo_id')->constrained('insumos');
            $table->foreignId('ubicacion_id')->nullable()->constrained('ubicaciones');
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores');
            $table->string('codigo_lote')->unique(); 
            $table->integer('cantidad_inicial');
            $table->integer('cantidad_actual');
            $table->date('fecha_entrada');
            $table->date('fecha_vencimiento')->nullable();
            $table->enum('estado', ['activo', 'agotado', 'vencido'])->default('activo');
            $table->foreignId('registrado_por')->constrained('users');

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotes');
    }
};