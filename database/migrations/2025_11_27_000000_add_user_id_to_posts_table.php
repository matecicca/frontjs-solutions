<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Agregar columna user_id como foreign key
            $table->foreignId('user_id')
                  ->nullable() // Nullable para posts antiguos sin autor
                  ->after('id')
                  ->constrained('users')
                  ->nullOnDelete(); // Si se elimina el usuario, user_id queda en null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
