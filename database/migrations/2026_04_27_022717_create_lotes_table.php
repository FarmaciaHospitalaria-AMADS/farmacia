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
            $table->foreignId('ubicacion_id')->nullable()->constrained('ubicaciones');

            $table->string('numero_lote');
            $table->date('fecha_vencimiento');

            $table->integer('cantidad_inicial');
            $table->integer('cantidad_actual');

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
