<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Teacher;

class TeacherDirectory extends Component
{
    public function render()
    {
        $teachers = Teacher::with('user')->get();
        return view('livewire.teacher-directory', compact('teachers'))->layout('layouts.livewire');
    }
}
