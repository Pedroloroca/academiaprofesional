<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #333; padding: 20px; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1e3a8a; padding-bottom: 12px; }
        h1 { color: #1e3a8a; margin: 0; font-size: 26px; }
        .courses-table { width: 100%; border-collapse: collapse; }
        .courses-table th { background-color: #f1f5f9; color: #1e293b; font-size: 13px; text-align: left; padding: 10px; border-bottom: 2px solid #cbd5e1; }
        .courses-table td { padding: 10px; border-bottom: 1px solid #e2e8f0; font-size: 13px; }
        .price { color: #1e3a8a; font-weight: bold; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Catálogo de Cursos</h1>
        <p style="font-size: 12px; color: #64748b; margin-top: 5px;">Cursos activos en la Academia Profesional</p>
    </div>

    <table class="courses-table">
        <thead>
            <tr>
                <th>Curso</th>
                <th>Instructor</th>
                <th style="text-align: right;">Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr>
                <td><strong>{{ $course->title }}</strong></td>
                <td>{{ $course->teacher->user->name ?? 'Profesor' }}</td>
                <td class="price">{{ number_format($course->price, 2) }} €</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
