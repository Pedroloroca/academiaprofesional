<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; text-align: center; color: #333; margin: 0; padding: 30px; border: 15px solid #1e3a8a; }
        .wrapper { border: 2px solid #3b82f6; padding: 40px; }
        .logo { font-size: 28px; font-weight: bold; color: #1e3a8a; margin-bottom: 20px; }
        .title { font-size: 38px; color: #1e3a8a; margin-top: 20px; margin-bottom: 10px; font-weight: bold; }
        .subtitle { font-size: 16px; color: #64748b; margin-bottom: 30px; }
        .student-name { font-size: 26px; font-weight: bold; margin-bottom: 25px; border-bottom: 1px dashed #cbd5e1; display: inline-block; padding-bottom: 5px; }
        .course-title { font-size: 22px; color: #1e3a8a; font-style: italic; margin-bottom: 30px; }
        .cert-details { font-size: 14px; color: #475569; margin-top: 30px; }
        .date { font-size: 13px; color: #64748b; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="logo">Academia Profesional</div>
        <div class="title">CERTIFICADO</div>
        <div class="subtitle">DE PARTICIPACIÓN Y APROVECHAMIENTO</div>
        <p>Por cuanto se otorga a:</p>
        <div class="student-name">{{ $enrollment->student->user->name ?? 'Estudiante' }}</div>
        <p>Por haber completado exitosamente y con distinción el programa académico de:</p>
        <div class="course-title">"{{ $enrollment->course->title ?? 'Curso Académico' }}"</div>
        <p class="cert-details">Calificación final obtenida: {{ number_format($enrollment->final_grade ?? 0, 1) }} / 10</p>
        <div class="date">Expedido el día {{ now()->format('d/m/Y') }}</div>
    </div>
</body>
</html>
