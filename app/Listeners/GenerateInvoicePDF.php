<?php
namespace App\Listeners;
use App\Events\PaymentReceived;
use Illuminate\Support\Facades\Log;

class GenerateInvoicePDF
{
    public function handle(PaymentReceived $event): void
    {
        Log::info("Generando factura PDF para la matrícula {$event->enrollment->id}");
    }
}