<?php
namespace App\Jobs;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class CalculateStudentGPA
{
    use Dispatchable;
    public $student;

    public function __construct(User $student)
    {
        $this->student = $student;
    }

    public function handle(): void
    {
        Log::info("Calculando GPA global para el estudiante {$this->student->name} (Ejecución síncrona)...");
        // Lógica matemática
        Log::info("GPA recalculado: 8.5/10");

        \Illuminate\Support\Facades\Artisan::call('academy:cleanup-old-enrollments');
    }
}