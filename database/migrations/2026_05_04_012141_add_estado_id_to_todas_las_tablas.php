<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $tablas = [
        'roles', 
        'users', 
        'categorias', 
        'proveedores', 
        'ubicaciones', 
        'areas', 
        'insumos', 
        'lotes', 
        'movimientos', 
        'alertas'
    ];

    public function up(): void
    {
        // 1. Apagamos las restricciones
        Schema::disableForeignKeyConstraints();

        foreach ($this->tablas as $tabla) {
            
            // 2. LIMPIEZA: Si la columna ya existe por el error anterior, la borramos
            if (Schema::hasColumn($tabla, 'estado_id')) {
                Schema::table($tabla, function (Blueprint $table) {
                    $table->dropColumn('estado_id');
                });
            }

            // 3. Ahora sí, creamos la columna y la llave foránea de forma limpia
            Schema::table($tabla, function (Blueprint $table) {
                $table->unsignedBigInteger('estado_id')->default(1);
                $table->foreign('estado_id')->references('id')->on('estados');
            });
        }

        // 4. Encendemos las restricciones
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach ($this->tablas as $tabla) {
            Schema::table($tabla, function (Blueprint $table) {
                $table->dropForeign(['estado_id']);
                $table->dropColumn('estado_id');
            });
        }

        Schema::enableForeignKeyConstraints();
    }
};