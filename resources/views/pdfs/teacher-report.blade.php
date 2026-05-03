<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #333; padding: 20px; line-height: 1.5; }
        .header { margin-bottom: 25px; border-bottom: 2px solid #1e3a8a; padding-bottom: 12px; }
        h1 { color: #1e3a8a; font-size: 24px; margin: 0; }
        .info { font-size: 13px; color: #475569; margin-top: 5px; }
        .report-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .report-table th { background-color: #f1f5f9; color: #1e293b; font-size: 13px; text-align: left; padding: 10px; border-bottom: 2px solid #cbd5e1; }
        .report-table td { padding: 10px; border-bottom: 1px solid #e2e8f0; font-size: 13px; }
        .summary-box { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px; margin-bottom: 20px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Resumen de Rendimiento del Profesor</h1>
        <div class="info">Profesor: <strong>{{ $teacher->user->name ?? 'N/A' }}</strong></div>
    </div>

    <div class="summary-box">
        <strong>Total cursos a su cargo:</strong> {{ $teacher->courses->count() }}<br>
        <strong>Total estudiantes matriculados:</strong> {{ $teacher->courses->sum(fn($c) => $c->enrollments->count()) }}
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Curso</th>
                <th>Estado</th>
                <th style="text-align: right;">Matrículas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teacher->courses as $course)
            <tr>
                <td>{{ $course->title }}</td>
                <td>{{ strtoupper($course->status) }}</td>
                <td style="text-align: right;">{{ $course->enrollments->count() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
