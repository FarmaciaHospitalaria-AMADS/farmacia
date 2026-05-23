<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ubicacion;

class UbicacionSeeder extends Seeder
{
    public function run(): void
    {
        $ubicaciones = [
            ['nombre' => 'Almacén Central de Farmacia', 'descripcion' => 'Bodega principal donde se recibe y clasifica todo el inventario de proveedores.'],
            ['nombre' => 'Farmacia Satélite de Emergencias', 'descripcion' => 'Sub-almacén abierto 24/7 para despacho inmediato a la sala de urgencias.'],
            ['nombre' => 'Cámara de Cadena de Frío', 'descripcion' => 'Cuartos fríos y refrigeradores con temperatura controlada (2°C a 8°C) para vacunas e insumos termolábiles.'],
            ['nombre' => 'Farmacia de Quirófano', 'descripcion' => 'Área estéril con inventario crítico pre-quirúrgico (anestesia, kits de cirugía).'],
            ['nombre' => 'Bodega de Materiales Controlados', 'descripcion' => 'Búnker de acceso restringido con doble cerradura para estupefacientes.']
        ];

        foreach ($ubicaciones as $ubicacion) {
            Ubicacion::create($ubicacion);
        }
    }
}