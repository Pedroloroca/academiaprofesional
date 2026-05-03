<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Course;

class UnpublishEmptyCourses extends Command
{
    protected $signature = 'academy:unpublish-empty-courses';
    protected $description = 'Unpublish courses that are published but have zero enrollments';

    public function handle()
    {
        $this->info('Finding published courses with zero enrollments...');

        $courses = Course::withCount('enrollments')
            ->where('status', 'published')
            ->get();

        $count = 0;
        foreach ($courses as $course) {
            if ($course->enrollments_count === 0) {
                $course->update(['status' => 'draft']);
                $this->line("- Course [{$course->id}] {$course->title} has been unpublished.");
                $count++;
            }
        }

        $this->info("Total courses unpublished: {$count}");
        return 0;
    }
}
