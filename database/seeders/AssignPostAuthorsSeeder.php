<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class AssignPostAuthorsSeeder extends Seeder
{
    /**
     * Asigna un autor a todos los posts que no tienen user_id.
     */
    public function run(): void
    {
        // Contar posts sin autor
        $postsWithoutAuthor = Post::whereNull('user_id')->count();

        if ($postsWithoutAuthor === 0) {
            $this->command->info('✓ Todos los posts ya tienen autor asignado.');
            return;
        }

        // Buscar el primer usuario admin
        $admin = User::where('role', 'admin')->first();

        // Si no hay admin, usar el primer usuario disponible
        if (!$admin) {
            $admin = User::first();
        }

        // Si no hay usuarios en absoluto, mostrar error
        if (!$admin) {
            $this->command->error('✗ No hay usuarios en la base de datos. Crea al menos un usuario primero.');
            return;
        }

        // Asignar el autor a todos los posts sin user_id
        $updated = Post::whereNull('user_id')->update(['user_id' => $admin->id]);

        $this->command->info("✓ Se asignó el autor '{$admin->name}' (ID: {$admin->id}) a {$updated} post(s).");
    }
}
