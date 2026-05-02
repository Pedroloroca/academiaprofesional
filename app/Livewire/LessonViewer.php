<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Lesson;

class LessonViewer extends Component
{
    public $course;
    public $activeLesson = null;
    
    // Toggles and check flags
    public $editMode = false;
    public $isTeacherOrAdmin = false;

    // Course fields for real-time editing
    public $course_id;
    public $courseTitle;
    public $courseDescription;
    public $courseExplanation;
    public $courseVideoUrl;

    // Active lesson fields
    public $active_lesson_title;
    public $active_lesson_content;
    public $active_lesson_is_published;
    public $active_lesson_video_url;

    // New lesson fields
    public $new_lesson_title;
    public $new_lesson_content;

    public function mount($slug)
    {
        $this->loadCourseData($slug);
    }

    public function loadCourseData($slug)
    {
        $user = auth()->user();
        
        $this->course = Course::where('slug', $slug)->firstOrFail();

        // If user is admin/manager or the course's teacher, load all lessons (published and unpublished)
        if ($user && ($user->hasRole('admin') || $user->hasRole('manager') || ($user->hasRole('teacher') && $this->course->teacher->user_id === $user->id))) {
            $this->isTeacherOrAdmin = true;
            $this->editMode = true; // default on edit mode for teachers
            
            // Reload with all lessons
            $this->course = Course::with(['lessons' => function($q) {
                $q->orderBy('position');
            }])->where('slug', $slug)->firstOrFail();
        } else {
            // Load only published lessons for students
            $this->course = Course::with(['lessons' => function($q) {
                $q->where('is_published', true)->orderBy('position');
            }])->where('slug', $slug)->firstOrFail();
        }

        // Fill course level fields
        $this->course_id = $this->course->id;
        $this->courseTitle = $this->course->title;
        $this->courseDescription = $this->course->description;
        $this->courseExplanation = $this->course->explanation;
        $this->courseVideoUrl = $this->course->video_url;

        if ($this->course->lessons->isNotEmpty()) {
            if (!$this->activeLesson) {
                $this->activeLesson = $this->course->lessons->first();
            } else {
                $this->activeLesson = $this->course->lessons->firstWhere('id', $this->activeLesson->id) ?: $this->course->lessons->first();
            }
            $this->loadLessonFields();
        }
    }

    public function loadLessonFields()
    {
        if ($this->activeLesson) {
            $this->active_lesson_title = $this->activeLesson->title;
            $this->active_lesson_content = $this->activeLesson->content;
            $this->active_lesson_is_published = (bool)$this->activeLesson->is_published;
            $this->active_lesson_video_url = $this->activeLesson->video_url;
        }
    }

    public function selectLesson($lessonId)
    {
        $this->activeLesson = $this->course->lessons->firstWhere('id', $lessonId);
        $this->loadLessonFields();
    }

    public function toggleEditMode()
    {
        $this->editMode = !$this->editMode;
    }

    public function completeLesson($lessonId)
    {
        $lesson = Lesson::find($lessonId);
        if ($lesson) {
            event(new \App\Events\LessonCompleted($lesson, auth()->user()));

            // Recalculate global student grade via sync Job
            \App\Jobs\CalculateStudentGPA::dispatch(auth()->user());

            session()->flash('message', '¡Lección completada con éxito!');
        }
    }

    public function updateCourse()
    {
        $this->validate([
            'courseTitle' => 'required',
            'courseDescription' => 'required',
        ]);

        $this->course->update([
            'title' => $this->courseTitle,
            'description' => $this->courseDescription,
            'explanation' => $this->courseExplanation,
            'video_url' => $this->courseVideoUrl,
        ]);

        session()->flash('course_message', 'Curso actualizado correctamente.');
        $this->loadCourseData($this->course->slug);
    }

    public function updateLesson()
    {
        if (!$this->activeLesson) return;

        $this->validate([
            'active_lesson_title' => 'required',
            'active_lesson_content' => 'required',
        ]);

        $this->activeLesson->update([
            'title' => $this->active_lesson_title,
            'content' => $this->active_lesson_content,
            'is_published' => $this->active_lesson_is_published,
            'video_url' => $this->active_lesson_video_url,
        ]);

        session()->flash('lesson_message', 'Lección actualizada correctamente.');
        $this->loadCourseData($this->course->slug);
    }

    public function addLesson()
    {
        $this->validate([
            'new_lesson_title' => 'required',
            'new_lesson_content' => 'required',
        ]);

        $this->course->lessons()->create([
            'title' => $this->new_lesson_title,
            'slug' => \Illuminate\Support\Str::slug($this->new_lesson_title) . '-' . uniqid(),
            'content' => $this->new_lesson_content,
            'is_published' => true,
        ]);

        $this->new_lesson_title = '';
        $this->new_lesson_content = '';

        session()->flash('course_message', 'Nueva lección añadida correctamente.');
        $this->loadCourseData($this->course->slug);
    }

    public function deleteLesson($id)
    {
        $lesson = Lesson::find($id);
        if ($lesson) {
            $lesson->delete();
            $this->activeLesson = null;
            session()->flash('course_message', 'Lección eliminada correctamente.');
            $this->loadCourseData($this->course->slug);
        }
    }

    public function render()
    {
        return view('livewire.lesson-viewer')->layout('layouts.livewire');
    }
}
