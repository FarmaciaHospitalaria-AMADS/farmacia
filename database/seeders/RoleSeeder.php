<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Role::create(['nombre' => 'Administrador']);
        Role::create(['nombre' => 'Farmaceutico']);
        Role::create(['nombre' => 'Enfermeria']);
    }
}
