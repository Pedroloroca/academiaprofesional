<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LessonReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $courseTitle;
    public $lessonTitle;

    public function __construct(string $courseTitle, string $lessonTitle)
    {
        $this->courseTitle = $courseTitle;
        $this->lessonTitle = $lessonTitle;
    }

    public function build()
    {
        return $this->subject('Recordatorio de Lección')
                    ->view('emails.lesson-reminder');
    }
}
