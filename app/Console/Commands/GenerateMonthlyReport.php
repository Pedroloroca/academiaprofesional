<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Course;
use App\Models\Enrollment;
use Carbon\Carbon;

class GenerateMonthlyReport extends Command
{
    protected $signature = 'academy:generate-monthly-report';
    protected $description = 'Generate academic monthly activity report';

    public function handle()
    {
        $this->info('Generating monthly activity report...');
        
        $coursesCount = Course::count();
        $totalEnrollments = Enrollment::count();
        $thisMonthEnrollments = Enrollment::where('enrolled_at', '>=', Carbon::now()->startOfMonth())->count();

        $this->line("Monthly Activity Summary:");
        $this->line("- Total Courses: {$coursesCount}");
        $this->line("- Total Enrollments All-time: {$totalEnrollments}");
        $this->line("- New Enrollments This Month: {$thisMonthEnrollments}");

        $this->info('Monthly report generated successfully.');
        return 0;
    }
}
