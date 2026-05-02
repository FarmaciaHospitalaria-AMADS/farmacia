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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->constrained('lotes');
            // Cambié user_id a usuario_id como pediste, pero sigue apuntando a la tabla 'users'
            $table->foreignId('user_id')->constrained('users'); 
            /* area_id es opcional, por eso lo puse como nullable. Puedes usarlo 
            para registrar en qué área o departamento se realizó el movimiento, 
            lo cual puede ser útil para los reportes */
            $table->foreignId('area_id')->nullable()->constrained('areas');
            $table->enum('tipo', ['entrada', 'salida']);
            $table->integer('cantidad');
            $table->enum('motivo', ['consumo paciente', 'ajuste', 'devolucion']);
            $table->string('referencia')->nullable(); 
            $table->dateTime('fecha')->useCurrent();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};