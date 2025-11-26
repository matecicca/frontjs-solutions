<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crea o actualiza el usuario admin
        User::updateOrCreate(
            ['name' => 'admin'],                             // buscamos por nombre
            [
                'name' => 'admin',
                'email' => 'admin@frontjs-solutions.test',   // email fijo para referencia
                'password' => Hash::make('pass123'),         // contraseña: pass123
            ]
        );
    }
}
