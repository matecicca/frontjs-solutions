<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización de Solicitud</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #6c757d;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-top: none;
        }
        .service-info {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #6c757d;
        }
        .message-box {
            background-color: #f8d7da;
            border: 1px solid #f5c2c7;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .original-message {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border: 1px solid #dee2e6;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-size: 12px;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        h1 {
            margin: 0;
            font-size: 24px;
        }
        h2 {
            color: #495057;
            font-size: 18px;
        }
        .label {
            font-weight: bold;
            color: #495057;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Actualización de tu Solicitud</h1>
    </div>

    <div class="content">
        <p>Hola <strong>{{ $request->nombre }}</strong>,</p>

        <p>Gracias por tu interés en nuestros servicios. Lamentamos informarte que, tras revisar tu solicitud, no hemos podido aceptarla en esta ocasión.</p>

        <div class="service-info">
            <h2>Detalles del Servicio Solicitado</h2>
            <p><span class="label">Tipo de servicio:</span> {{ $request->tipo_servicio }}</p>
            @if ($request->empresa)
                <p><span class="label">Empresa:</span> {{ $request->empresa }}</p>
            @endif
            <p><span class="label">Fecha de solicitud:</span> {{ $request->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <div class="original-message">
            <h2>Tu mensaje original</h2>
            <p>{{ $request->descripcion_proyecto }}</p>
        </div>

        @if ($request->admin_message)
            <div class="message-box">
                <h2>Mensaje de FrontJS Solutions</h2>
                <p>{{ $request->admin_message }}</p>
            </div>
        @endif

        <p>Te invitamos a enviarnos una nueva solicitud si lo deseas, o contactarnos para obtener más información sobre nuestros servicios.</p>

        <p>Saludos cordiales,<br>
        <strong>El equipo de FrontJS Solutions</strong></p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} FrontJS Solutions. Todos los derechos reservados.</p>
        <p>Este es un correo generado automáticamente, por favor no respondas a este mensaje.</p>
    </div>
</body>
</html>
