<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Course;

class RecalculateStats extends Command
{
    protected $signature = 'academy:recalculate-stats';
    protected $description = 'Recalculate enrollment and grades stats for each course';

    public function handle()
    {
        $this->info('Starting recalculation of course stats...');
        $courses = Course::with('enrollments')->get();

        foreach ($courses as $course) {
            $enrollmentCount = $course->enrollments()->count();
            $avgGrade = $course->enrollments()->whereNotNull('final_grade')->avg('final_grade') ?? 0;

            $this->line("- Course: [{$course->id}] {$course->title} | Enrollments: {$enrollmentCount} | Avg Grade: " . number_format($avgGrade, 2));
        }

        $this->info('Course stats recalculation completed.');
        return 0;
    }
}
