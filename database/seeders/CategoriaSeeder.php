<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Analgésicos y Antipiréticos', 'descripcion' => 'Medicamentos para el control del dolor y la reducción de la fiebre.'],
            ['nombre' => 'Antibióticos de Amplio Espectro', 'descripcion' => 'Fármacos para el tratamiento de infecciones bacterianas severas y sepsis.'],
            ['nombre' => 'Anestésicos y Sedantes', 'descripcion' => 'Uso exclusivo en quirófanos, procedimientos invasivos y UCI.'],
            ['nombre' => 'Medicamentos Cardiovasculares', 'descripcion' => 'Tratamiento de hipertensión, arritmias, paros cardíacos y shock.'],
            ['nombre' => 'Fluidos Intravenosos', 'descripcion' => 'Sueros salinos, glucosados, ringer lactato y soluciones electrolíticas.'],
            ['nombre' => 'Material Médico Quirúrgico', 'descripcion' => 'Insumos descartables como jeringas, catéteres, gasas y material de sutura.'],
            ['nombre' => 'Psicotrópicos y Estupefacientes', 'descripcion' => 'Medicamentos controlados bajo estricta vigilancia médica y receta retenida.'],
            ['nombre' => 'Medicamentos Oncológicos', 'descripcion' => 'Fármacos de alto costo para quimioterapia y tratamientos contra el cáncer.']
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}