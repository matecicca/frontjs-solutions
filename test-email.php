<?php

/**
 * Script de prueba para verificar el envío de correos con Gmail
 *
 * Ejecutar desde la raíz del proyecto Laravel:
 * php test-email.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;

echo "🔄 Intentando enviar correo de prueba...\n\n";

try {
    Mail::raw('Este es un correo de prueba desde Laravel con Gmail SMTP.', function ($message) {
        $message->to('mateociccarello@gmail.com')
                ->subject('Prueba de Gmail SMTP - Laravel');
    });

    echo "✅ ¡Correo enviado exitosamente!\n";
    echo "📧 Revisa tu bandeja de entrada: mateociccarello@gmail.com\n";
    echo "📁 También revisa la carpeta de SPAM por las dudas.\n";
} catch (\Exception $e) {
    echo "❌ Error al enviar el correo:\n";
    echo $e->getMessage() . "\n\n";
    echo "💡 Verifica:\n";
    echo "   1. Que hayas configurado la contraseña de aplicación de Google\n";
    echo "   2. Que la verificación en dos pasos esté activa\n";
    echo "   3. Que hayas ejecutado: php artisan config:clear\n";
}
