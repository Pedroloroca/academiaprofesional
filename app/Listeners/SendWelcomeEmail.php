<?php
namespace App\Listeners;
use App\Events\StudentEnrolled;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnrollmentConfirmation;

class SendWelcomeEmail
{
    public function handle(StudentEnrolled $event): void
    {
        Log::info("Enviando email de bienvenida al alumno {$event->enrollment->student_id} para el curso {$event->enrollment->course_id}");

        $student = $event->enrollment->student;
        if ($student && $student->user && $student->user->email) {
            Mail::to($student->user->email)->send(new EnrollmentConfirmation($event->enrollment));
            Log::info("Email de confirmación de matrícula enviado.");
        }
    }
}