<?php
namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessVideoUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $videoId;

    public function __construct($videoId)
    {
        $this->videoId = $videoId;
    }

    public function handle(): void
    {
        Log::info("Procesando vídeo pesado en background (Video ID: {$this->videoId})...");
        sleep(2); // Simular procesamiento
        Log::info("Vídeo {$this->videoId} procesado con éxito.");
    }
}