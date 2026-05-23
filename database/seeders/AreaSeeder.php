<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            ['nombre' => 'Unidad de Cuidados Intensivos (UCI)', 'descripcion' => 'Área de alta complejidad para pacientes en estado crítico que requieren soporte vital.'],
            ['nombre' => 'Sala de Operaciones', 'descripcion' => 'Quirófanos habilitados para intervenciones quirúrgicas de emergencia y programadas.'],
            ['nombre' => 'Área de Triage y Urgencias', 'descripcion' => 'Clasificación de pacientes y atención médica inmediata.'],
            ['nombre' => 'Pabellón de Hospitalización General', 'descripcion' => 'Área de internamiento prolongado para recuperación y observación.'],
            ['nombre' => 'Unidad de Maternidad y Neonatología', 'descripcion' => 'Atención de partos, cuidados pre/post natales y cuidados intensivos para recién nacidos.'],
            ['nombre' => 'Clínica Oncológica Ambulatoria', 'descripcion' => 'Área especializada para la administración de sesiones de quimioterapia.']
        ];

        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}