<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega campos para relacionar solicitudes con usuarios y gestionar estados.
     */
    public function up(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            // Relación con el usuario que envía la solicitud
            $table->foreignId('user_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('users')
                  ->nullOnDelete();

            // Estado de la solicitud: revision (default), aceptado, rechazado
            $table->string('status', 20)
                  ->default('revision')
                  ->after('descripcion_proyecto');

            // Mensaje del administrador al aceptar o rechazar
            $table->text('admin_message')
                  ->nullable()
                  ->after('status');

            // Fecha/hora de aceptación (para registro de cuándo se envió el mail)
            $table->timestamp('accepted_at')
                  ->nullable()
                  ->after('admin_message');
        });
    }

    /**
     * Reversa los cambios de la migración.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'status', 'admin_message', 'accepted_at']);
        });
    }
};
