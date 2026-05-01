<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;

class LessonViewer extends Component
{
    public $course;
    public $activeLesson = null;

    public function mount($slug)
    {
        $this->course = Course::with(['lessons' => function($q) {
            $q->where('is_published', true)->orderBy('position');
        }])->where('slug', $slug)->firstOrFail();
        
        if ($this->course->lessons->isNotEmpty()) {
            $this->activeLesson = $this->course->lessons->first();
        }
    }

    public function selectLesson($lessonId)
    {
        $this->activeLesson = $this->course->lessons->firstWhere('id', $lessonId);
    }

    public function render()
    {
        return view('livewire.lesson-viewer')->layout('layouts.livewire');
    }
}
