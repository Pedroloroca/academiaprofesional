<?php
namespace App\Listeners;
use App\Events\StudentEnrolled;
use Illuminate\Support\Facades\Log;

class SendWelcomeEmail
{
    public function handle(StudentEnrolled $event): void
    {
        Log::info("Enviando email de bienvenida al alumno {$event->enrollment->student_id} para el curso {$event->enrollment->course_id}");
    }
}