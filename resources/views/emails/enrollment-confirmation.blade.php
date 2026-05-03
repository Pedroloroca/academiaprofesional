<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; background-color: #f8fafc; }
        h1 { color: #1e3a8a; font-size: 24px; margin-bottom: 16px; }
        p { margin-bottom: 12px; }
        .footer { font-size: 12px; color: #64748b; margin-top: 24px; border-top: 1px solid #e2e8f0; padding-top: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>¡Hola, {{ $enrollment->student->user->name ?? 'Estudiante' }}!</h1>
        <p>Te confirmamos que te has matriculado exitosamente en el curso:</p>
        <p><strong>{{ $enrollment->course->title ?? 'Curso' }}</strong></p>
        <p>Fecha de inscripción: {{ $enrollment->enrolled_at->format('d/m/Y') }}</p>
        <p>Estado de la matrícula: {{ strtoupper($enrollment->status) }}</p>
        <p>¡Te deseamos el mayor de los éxitos en tu aprendizaje!</p>
        <div class="footer">
            Este es un correo automático de Academia Profesional. Por favor, no respondas a este mensaje.
        </div>
    </div>
</body>
</html>
