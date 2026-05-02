<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Lesson;

class LessonViewer extends Component
{
    public $course_slug;
    public $active_lesson_id = null;
    
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
        $this->course_slug = $slug;
        $this->loadCourseData($slug);
    }

    public function loadCourseData($slug)
    {
        $user = auth()->user();
        $course = Course::where('slug', $slug)->firstOrFail();

        // If user is admin/manager or the course's teacher, load all lessons (published and unpublished)
        if ($user && ($user->hasRole('admin') || $user->hasRole('manager') || ($user->hasRole('teacher') && $course->teacher->user_id === $user->id))) {
            $this->isTeacherOrAdmin = true;
            $this->editMode = true; // default on edit mode for teachers
            
            // Reload with all lessons
            $course = Course::with(['lessons' => function($q) {
                $q->orderBy('position');
            }])->where('slug', $slug)->firstOrFail();
        } else {
            // Load only published lessons for students
            $course = Course::with(['lessons' => function($q) {
                $q->where('is_published', true)->orderBy('position');
            }])->where('slug', $slug)->firstOrFail();
        }

        // Fill course level fields
        $this->course_id = $course->id;
        $this->courseTitle = $course->title;
        $this->courseDescription = $course->description;
        $this->courseExplanation = $course->explanation;
        $this->courseVideoUrl = $course->video_url;

        if ($course->lessons->isNotEmpty()) {
            if (!$this->active_lesson_id) {
                $activeLesson = $course->lessons->first();
                $this->active_lesson_id = $activeLesson->id;
            } else {
                $activeLesson = $course->lessons->firstWhere('id', $this->active_lesson_id) ?: $course->lessons->first();
                $this->active_lesson_id = $activeLesson->id;
            }
            $this->loadLessonFields($activeLesson);
        }
    }

    public function loadLessonFields($lesson)
    {
        if ($lesson) {
            $this->active_lesson_title = $lesson->title;
            $this->active_lesson_content = $lesson->content;
            $this->active_lesson_is_published = (bool)$lesson->is_published;
            $this->active_lesson_video_url = $lesson->video_url;
        }
    }

    public function selectLesson($lessonId)
    {
        $this->active_lesson_id = $lessonId;
        $lesson = Lesson::find($lessonId);
        $this->loadLessonFields($lesson);
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

        $course = Course::findOrFail($this->course_id);
        $course->update([
            'title' => $this->courseTitle,
            'description' => $this->courseDescription,
            'explanation' => $this->courseExplanation,
            'video_url' => $this->courseVideoUrl,
        ]);

        session()->flash('course_message', 'Curso actualizado correctamente.');
        $this->loadCourseData($this->course_slug);
    }

    public function updateLesson()
    {
        if (!$this->active_lesson_id) return;

        $this->validate([
            'active_lesson_title' => 'required',
            'active_lesson_content' => 'required',
        ]);

        $lesson = Lesson::findOrFail($this->active_lesson_id);
        $lesson->update([
            'title' => $this->active_lesson_title,
            'content' => $this->active_lesson_content,
            'is_published' => $this->active_lesson_is_published,
            'video_url' => $this->active_lesson_video_url,
        ]);

        session()->flash('lesson_message', 'Lección actualizada correctamente.');
        $this->loadCourseData($this->course_slug);
    }

    public function addLesson()
    {
        $this->validate([
            'new_lesson_title' => 'required',
            'new_lesson_content' => 'required',
        ]);

        $course = Course::findOrFail($this->course_id);
        $course->lessons()->create([
            'title' => $this->new_lesson_title,
            'slug' => \Illuminate\Support\Str::slug($this->new_lesson_title) . '-' . uniqid(),
            'content' => $this->new_lesson_content,
            'is_published' => true,
        ]);

        $this->new_lesson_title = '';
        $this->new_lesson_content = '';

        session()->flash('course_message', 'Nueva lección añadida correctamente.');
        $this->loadCourseData($this->course_slug);
    }

    public function deleteLesson($id)
    {
        $lesson = Lesson::find($id);
        if ($lesson) {
            $lesson->delete();
            $this->active_lesson_id = null;
            session()->flash('course_message', 'Lección eliminada correctamente.');
            $this->loadCourseData($this->course_slug);
        }
    }

    public function render()
    {
        $course = Course::where('slug', $this->course_slug)->firstOrFail();
        $user = auth()->user();

        if ($user && ($user->hasRole('admin') || $user->hasRole('manager') || ($user->hasRole('teacher') && $course->teacher->user_id === $user->id))) {
            $course = Course::with(['lessons' => function($q) {
                $q->orderBy('position');
            }])->where('slug', $this->course_slug)->firstOrFail();
        } else {
            $course = Course::with(['lessons' => function($q) {
                $q->where('is_published', true)->orderBy('position');
            }])->where('slug', $this->course_slug)->firstOrFail();
        }

        $activeLesson = null;
        if ($this->active_lesson_id) {
            $activeLesson = $course->lessons->firstWhere('id', $this->active_lesson_id) ?: $course->lessons->first();
        } elseif ($course->lessons->isNotEmpty()) {
            $activeLesson = $course->lessons->first();
        }

        return view('livewire.lesson-viewer', [
            'course' => $course,
            'activeLesson' => $activeLesson,
        ])->layout('layouts.livewire');
    }
}
