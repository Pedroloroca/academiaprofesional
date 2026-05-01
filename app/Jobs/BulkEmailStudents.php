<?php
namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Course;

class BulkEmailStudents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function handle(): void
    {
        Log::info("Iniciando envío masivo de correos para publicitar el curso {$this->course->title}...");
        sleep(3);
        Log::info("Correos masivos enviados.");
    }
}