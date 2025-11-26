<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::create([
            'titulo' => 'Las tendencias más recientes en desarrollo frontend',
            'slug' => 'tendencias-desarrollo-frontend',
            'resumen' => 'Exploramos las nuevas herramientas y frameworks que dominan el desarrollo frontend moderno.',
            'contenido' => 'En la actualidad, el éxito de un producto digital depende en gran parte de la experiencia del usuario. Un frontend optimizado no solo mejora la velocidad de carga, sino que también transmite profesionalismo y genera confianza en los visitantes.
                            En FrontJS Solutions trabajamos bajo principios de diseño centrado en el usuario, utilizando tecnologías como React, Vue y TypeScript para lograr interfaces que sean intuitivas, accesibles y visualmente atractivas.
                            Cada línea de código está pensada para equilibrar estética, usabilidad y rendimiento. Porque un sitio rápido y bien estructurado no solo atrae más visitantes, sino que también mejora la conversión y la percepción de marca.',
            'imagen' => 'blog/frontend-trends.jpg'
        ]);

        Post::create([
            'titulo' => 'Por qué elegir React para tu próximo proyecto web',
            'slug' => 'elegir-react-proyecto',
            'resumen' => 'React ofrece una combinación única de flexibilidad, rendimiento y ecosistema de componentes.',
            'contenido' => 'React.js se ha consolidado como una de las librerías más utilizadas en el desarrollo web moderno. Su enfoque basado en componentes permite crear interfaces dinámicas, modulares y fáciles de mantener.
                            Gracias al Virtual DOM, React optimiza los procesos de renderizado, haciendo que las aplicaciones sean más rápidas y eficientes. Además, su ecosistema —que incluye herramientas como React Router, Redux o Next.js— ofrece soluciones completas para proyectos de cualquier escala.
                            En FrontJS Solutions implementamos React para construir aplicaciones personalizadas, escalables y con experiencias de usuario fluidas. Desde dashboards hasta landing pages interactivas, React nos permite adaptar la tecnología a las necesidades reales de cada cliente.',
            'imagen' => 'blog/react-benefits.jpg'
        ]);

        Post::create([
            'titulo' => 'Vue.js: simplicidad, modularidad y elegancia',
            'slug' => 'vuejs-simplicidad-modularidad',
            'resumen' => 'Vue.js se ha convertido en una opción favorita por su curva de aprendizaje suave y su potencia en proyectos complejos.',
            'contenido' => 'Vue.js combina la potencia de los frameworks modernos con una sintaxis clara y accesible. Su arquitectura progresiva permite integrarlo fácilmente en proyectos existentes o construir desde cero aplicaciones completas con un código limpio y organizado.
                            Uno de sus grandes atractivos es su sistema de reactividad, que actualiza automáticamente la interfaz cuando cambian los datos, reduciendo errores y tiempo de desarrollo.
                            En FrontJS Solutions utilizamos Vue para desarrollar aplicaciones eficientes y elegantes, manteniendo una estructura escalable que facilita el mantenimiento a largo plazo. Su equilibrio entre simplicidad y rendimiento lo convierte en una opción ideal para proyectos ágiles y de rápida implementación.',
            'imagen' => 'blog/vue-overview.jpg'
        ]);
    }
}
