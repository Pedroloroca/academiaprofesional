<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #333; margin: 0; padding: 24px; line-height: 1.5; }
        .header { margin-bottom: 30px; }
        .title { font-size: 24px; color: #1e3a8a; margin: 0; font-weight: bold; }
        .invoice-details { float: right; text-align: right; font-size: 13px; color: #64748b; }
        .client-info { margin-bottom: 24px; font-size: 14px; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 14px; }
        .invoice-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .invoice-table th { background-color: #f1f5f9; color: #1e293b; font-size: 13px; text-align: left; padding: 10px; border-bottom: 2px solid #cbd5e1; }
        .invoice-table td { padding: 10px; border-bottom: 1px solid #e2e8f0; font-size: 13px; }
        .total { text-align: right; font-size: 16px; font-weight: bold; margin-top: 14px; color: #1e3a8a; }
        .footer { font-size: 11px; color: #94a3b8; text-align: center; margin-top: 50px; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="invoice-details">
            <strong>Factura Nº:</strong> INV-{{ now()->year }}-{{ $enrollment->id }}<br>
            <strong>Fecha:</strong> {{ now()->format('d/m/Y') }}
        </div>
        <div class="title">Academia Profesional</div>
    </div>

    <div class="client-info">
        <strong>Detalles del Cliente:</strong><br>
        <strong>Nombre:</strong> {{ $enrollment->student->user->name ?? 'N/A' }}<br>
        <strong>Email:</strong> {{ $enrollment->student->user->email ?? 'N/A' }}
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>Concepto / Curso</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $enrollment->course->title ?? 'Curso Académico' }}</td>
                <td style="text-align: right;">{{ number_format($enrollment->course->price ?? 0, 2) }} €</td>
            </tr>
        </tbody>
    </table>

    <div class="total">
        Total: {{ number_format($enrollment->course->price ?? 0, 2) }} €
    </div>

    <div class="footer">
        Academia Profesional S.A. - Gracias por su confianza.
    </div>
</body>
</html>
