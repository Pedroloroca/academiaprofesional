<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;

class HomePage extends Component
{
    public $coursesCount;
    public $studentsCount;
    public $teachersCount;

    public function mount()
    {
        $this->coursesCount = Course::count();
        $this->studentsCount = Student::count();
        $this->teachersCount = Teacher::count();
    }

    public function render()
    {
        return view('livewire.home-page')->layout('layouts.livewire');
    }
}
