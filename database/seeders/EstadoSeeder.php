<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estado;

class EstadoSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['id' => 1, 'nombre' => 'Activo'],
            ['id' => 2, 'nombre' => 'Inactivo'],
            ['id' => 3, 'nombre' => 'En Cuarentena'], // Crítico para medicamentos retenidos o bajo investigación
            ['id' => 4, 'nombre' => 'Agotado'],       // Sin stock (Stock Out)
            ['id' => 5, 'nombre' => 'Descontinuado']  // Fármacos que el hospital ya no compra
        ];

        foreach ($estados as $estado) {
            Estado::updateOrCreate(
                ['id' => $estado['id']], 
                ['nombre' => $estado['nombre']]
            );
        }
    }
}