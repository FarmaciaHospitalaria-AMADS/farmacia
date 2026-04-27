<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $admin = Role::where('nombre', 'Administrador')->first();
        $farm = Role::where('nombre', 'Farmaceutico')->first();
        $enf = Role::where('nombre', 'Enfermeria')->first();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'password' => Hash::make('12345678'),
            'role_id' => $admin->id
        ]);

        User::create([
            'name' => 'Farmaceutico',
            'email' => 'farm@demo.com',
            'password' => Hash::make('12345678'),
            'role_id' => $farm->id
        ]);

        User::create([
            'name' => 'Enfermero',
            'email' => 'enf@demo.com',
            'password' => Hash::make('12345678'),
            'role_id' => $enf->id
        ]);
    }
}