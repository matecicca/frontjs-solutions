<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Usuario administrador
        User::updateOrCreate(
            ['email' => 'admin@frontjs-solutions.test'], // buscamos por email para evitar duplicados
            [
                'name'     => 'admin',
                'email'    => 'admin@frontjs-solutions.test',
                'password' => Hash::make('pass123'), // contraseña: pass123
                'role'     => 'admin',               // rol administrador
            ]
        );

        // 🔹 Usuario estándar (no admin)
        User::updateOrCreate(
            ['email' => 'claudio@gmail.com'],       // buscamos por email
            [
                'name'     => 'claudio',
                'email'    => 'claudio@gmail.com',
                'password' => Hash::make('pass123'), // misma contraseña: pass123
                'role'     => 'user',                // rol usuario común
            ]
        );

        // 🔹 Usuario Mateo
        User::updateOrCreate(
            ['email' => 'mateociccarello@gmail.com'],
            [
                'name'     => 'Mateo',
                'email'    => 'mateociccarello@gmail.com',
                'password' => Hash::make('pass123'), // contraseña: pass123
                'role'     => 'user',                // rol usuario común
            ]
        );
    }
}
