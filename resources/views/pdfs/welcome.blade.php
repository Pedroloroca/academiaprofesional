<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 24px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #3b82f6; padding-bottom: 12px; }
        h1 { color: #1e3a8a; margin: 0; font-size: 26px; }
        .date { font-size: 12px; color: #64748b; margin-top: 6px; }
        .welcome-box { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 18px; margin-bottom: 24px; }
        p { margin-bottom: 14px; font-size: 14px; }
        .footer { font-size: 12px; color: #64748b; margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 12px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Academia Profesional</h1>
        <div class="date">{{ now()->format('d/m/Y') }}</div>
    </div>
    <div class="welcome-box">
        <p><strong>¡Te damos la bienvenida, {{ $user->name }}!</strong></p>
        <p>Estamos entusiasmados de tenerte con nosotros en la plataforma. Esperamos que tu experiencia sea excelente y que aproveches todos los contenidos y recursos formativos que ponemos a tu disposición.</p>
    </div>
    <p>A partir de este momento tienes acceso completo a la exploración del catálogo de cursos. Si tienes cualquier duda, nuestro equipo de soporte está aquí para ayudarte.</p>
    <div class="footer">
        Academia Profesional S.A. - Todos los derechos reservados.
    </div>
</body>
</html>
