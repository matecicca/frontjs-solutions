<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Request;

class RequestSeeder extends Seeder
{
    public function run(): void
    {
        Request::create([
            'nombre' => 'María Gómez',
            'email' => 'maria@example.com',
            'empresa' => 'TechNow',
            'tipo_servicio' => 'React',
            'descripcion_proyecto' => 'Desarrollo de panel administrativo en React con integración a API REST.'
        ]);

        Request::create([
            'nombre' => 'Carlos Pérez',
            'email' => 'carlos@example.com',
            'empresa' => 'InnovApp',
            'tipo_servicio' => 'Vue',
            'descripcion_proyecto' => 'Sitio web interactivo con Vue 3 y Vite, optimizado para SEO y velocidad.'
        ]);
    }
}
