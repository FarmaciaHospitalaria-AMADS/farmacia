<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            
            // dejé ubicacion_id comentada por si la ocupas más adelante. 
            // puedes descomentarla si la necesitas. 
            // este campo puede ser útil para saber dónde se encuentra físicamente cada lote dentro del almacén o bodega.
            // $table->foreignId('ubicacion_id')->nullable()->constrained('ubicaciones');

            $table->string('codigo_lote')->unique(); 
            $table->string('codigo_producto');
            $table->integer('cantidad_inicial');
            $table->integer('cantidad_actual');
            $table->date('fecha_entrada');
            $table->date('fecha_vencimiento')->nullable(); // nullable() por si algun insumo no caduca
            $table->string('proveedor'); 
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