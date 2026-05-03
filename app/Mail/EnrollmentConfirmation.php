<?php

namespace App\Mail;

use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnrollmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $enrollment;

    public function __construct(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
    }

    public function build()
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdfs.invoice', ['enrollment' => $this->enrollment]);

        return $this->subject('Confirmación de Matrícula')
                    ->view('emails.enrollment-confirmation')
                    ->attachData($pdf->output(), "invoice-{$this->enrollment->id}.pdf", [
                        'mime' => 'application/pdf',
                    ]);
    }
}
