<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Teacher;

class NotifyTeachers extends Command
{
    protected $signature = 'academy:notify-teachers';
    protected $description = 'Simulate sending summary notifications to teachers';

    public function handle()
    {
        $this->info('Starting teacher notifications...');
        $teachers = Teacher::with('user', 'courses.enrollments')->get();

        foreach ($teachers as $teacher) {
            if (!$teacher->user) continue;

            $totalStudents = $teacher->courses->sum(function ($course) {
                return $course->enrollments->count();
            });

            $this->line("- Notified Teacher [{$teacher->id}] {$teacher->user->name} | Total enrolled students: {$totalStudents}");
        }

        $this->info('All teacher notifications sent successfully.');
        return 0;
    }
}
