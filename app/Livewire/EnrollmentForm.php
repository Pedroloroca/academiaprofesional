<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Student;

class EnrollmentForm extends Component
{
    public $course;
    public $student_id;

    public function mount($slug)
    {
        $this->course = Course::where('slug', $slug)->firstOrFail();
    }

    public function enroll()
    {
        $this->validate([
            'student_id' => 'required|exists:students,id'
        ]);

        $student = Student::find($this->student_id);
        
        // Prevent duplicate enrollment
        if ($student->courses()->where('course_id', $this->course->id)->exists()) {
            session()->flash('error', 'El estudiante ya está matriculado en este curso.');
            return;
        }

        $student->courses()->attach($this->course->id, [
            'status' => 'active',
            'enrolled_at' => now(),
        ]);

        $enrollment = \App\Models\Enrollment::where('student_id', $student->id)
            ->where('course_id', $this->course->id)
            ->first();

        if ($enrollment) {
            // Dispatch Events
            event(new \App\Events\StudentEnrolled($enrollment));
            event(new \App\Events\PaymentReceived($enrollment));
        }

        // Dispatch sync job to update course stats
        \App\Jobs\UpdateCourseStats::dispatch($this->course);

        session()->flash('message', 'Matriculación completada con éxito.');
        $this->student_id = '';
    }

    public function render()
    {
        $students = Student::with('user')->get();
        return view('livewire.enrollment-form', compact('students'))->layout('layouts.livewire');
    }
}
