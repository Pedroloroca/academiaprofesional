<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Course;
use Carbon\Carbon;

class ArchiveOldCourses extends Command
{
    protected $signature = 'academy:archive-old-courses {--days=365 : Number of days of inactivity before archiving}';
    protected $description = 'Archive courses that are old and inactive';

    public function handle()
    {
        $days = (int) $this->option('days');
        $this->info("Starting archiving of courses inactive for more than {$days} days...");

        $date = Carbon::now()->subDays($days);
        $courses = Course::where('created_at', '<', $date)
            ->where('status', '!=', 'archived')
            ->get();

        $count = 0;
        foreach ($courses as $course) {
            $course->update(['status' => 'archived']);
            $count++;
        }

        $this->info("Successfully archived {$count} old courses.");
        return 0;
    }
}
