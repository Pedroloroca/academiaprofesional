<?php
namespace App\Events;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LessonCompleted
{
    use Dispatchable, SerializesModels;
    public $lesson;
    public $user;

    public function __construct(Lesson $lesson, User $user)
    {
        $this->lesson = $lesson;
        $this->user = $user;
    }
}