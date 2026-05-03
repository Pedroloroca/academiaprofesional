<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Enrollment;
use Carbon\Carbon;

class CleanupOldEnrollments extends Command
{
    protected $signature = 'academy:cleanup-old-enrollments {--days=365 : Number of days old for enrollment cleanup}';
    protected $description = 'Cleanup or delete old/inactive enrollments';

    public function handle()
    {
        $days = (int) $this->option('days');
        $this->info("Starting cleanup of old enrollments older than {$days} days...");

        $date = Carbon::now()->subDays($days);
        
        $count = Enrollment::where('enrolled_at', '<', $date)
            ->where('status', '!=', 'active')
            ->delete();

        $this->info("Successfully deleted {$count} old enrollments.");
        return 0;
    }
}
