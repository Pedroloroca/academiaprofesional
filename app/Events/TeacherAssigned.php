<?php
namespace App\Events;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TeacherAssigned
{
    use Dispatchable, SerializesModels;
    public $course;
    public $teacher;

    public function __construct(Course $course, User $teacher)
    {
        $this->course = $course;
        $this->teacher = $teacher;
    }
}