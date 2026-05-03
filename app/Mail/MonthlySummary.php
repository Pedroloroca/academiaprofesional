<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlySummary extends Mailable
{
    use Queueable, SerializesModels;

    public $recipientName;
    public $monthName;
    public $coursesCount;
    public $enrollmentsCount;

    public function __construct(string $recipientName, string $monthName, int $coursesCount, int $enrollmentsCount)
    {
        $this->recipientName = $recipientName;
        $this->monthName     = $monthName;
        $this->coursesCount  = $coursesCount;
        $this->enrollmentsCount = $enrollmentsCount;
    }

    public function build()
    {
        return $this->subject('Resumen Mensual de Actividad')
                    ->view('emails.monthly-summary');
    }
}
