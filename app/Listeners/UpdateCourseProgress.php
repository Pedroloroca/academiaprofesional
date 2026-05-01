<?php
namespace App\Listeners;
use App\Events\LessonCompleted;
use Illuminate\Support\Facades\Log;

class UpdateCourseProgress
{
    public function handle(LessonCompleted $event): void
    {
        Log::info("Actualizando progreso del alumno {$event->user->id} en la lección {$event->lesson->id}");
    }
}