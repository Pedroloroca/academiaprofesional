<?php
namespace App\Listeners;
use App\Events\CoursePublished;
use App\Jobs\BulkEmailStudents;
use Illuminate\Support\Facades\Log;

class NotifyStudentsAboutNewCourse
{
    public function handle(CoursePublished $event): void
    {
        Log::info("El curso {$event->course->title} ha sido publicado. Despachando BulkEmailStudents Job.");
        BulkEmailStudents::dispatch($event->course);
    }
}