<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncExternalData extends Command
{
    protected $signature = 'academy:sync-external-data';
    protected $description = 'Fetch and sync quotes or academic tip from an external API';

    public function handle()
    {
        $this->info('Starting synchronization with external data source...');
        
        try {
            $response = Http::timeout(5)->get('https://jsonplaceholder.typicode.com/todos/1');
            if ($response->successful()) {
                $data = $response->json();
                $this->line("Data received from API: Title -> " . $data['title']);
                $this->info('Synchronization completed successfully.');
            } else {
                $this->warn('API request failed. Synchronization aborted.');
            }
        } catch (\Exception $e) {
            $this->error('Error communicating with external API: ' . $e->getMessage());
        }

        return 0;
    }
}
