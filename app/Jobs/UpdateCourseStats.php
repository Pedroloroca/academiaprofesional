<?php
namespace App\Jobs;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Models\Course;

class UpdateCourseStats
{
    use Dispatchable;
    public $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function handle(): void
    {
        Log::info("Actualizando estadísticas cacheadas para el curso {$this->course->title} (Ejecución síncrona)...");
        // Count enrollments
        $count = $this->course->enrollments()->count();
        Log::info("Alumnos matriculados totales: {$count}");
    }
}