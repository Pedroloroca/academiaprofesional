<?php
namespace App\Listeners;
use App\Events\PaymentReceived;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Payment;
use App\Mail\PaymentReceived as PaymentReceivedMail;

class GenerateInvoicePDF
{
    public function handle(PaymentReceived $event): void
    {
        Log::info("Generando factura PDF para la matrícula {$event->enrollment->id}");

        $payment = Payment::where('enrollment_id', $event->enrollment->id)->first();
        if ($payment && $payment->student && $payment->student->user && $payment->student->user->email) {
            Mail::to($payment->student->user->email)->send(new PaymentReceivedMail($payment));
            Log::info("Email de confirmación de pago recibido enviado.");
        }
    }
}