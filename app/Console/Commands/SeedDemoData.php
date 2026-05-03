<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedDemoData extends Command
{
    protected $signature = 'academy:seed-demo-data';
    protected $description = 'Seed the database with demo data';

    public function handle()
    {
        $this->info('Starting database seeding with demo data...');

        Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\DemoDataSeeder'
        ]);

        $this->info('Database demo data seeded successfully.');
        return 0;
    }
}
