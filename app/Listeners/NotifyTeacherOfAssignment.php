<?php
namespace App\Listeners;
use App\Events\TeacherAssigned;
use Illuminate\Support\Facades\Log;

class NotifyTeacherOfAssignment
{
    public function handle(TeacherAssigned $event): void
    {
        Log::info("Avisando al profesor {$event->teacher->name} de su asignación al curso {$event->course->title}");
    }
}