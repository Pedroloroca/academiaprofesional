<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Teacher;

class CourseManager extends Component
{
    public $courses, $teachers;
    public $course_id, $title, $description, $price, $teacher_id, $status;
    public $isOpen = false;

    public function mount()
    {
        $this->teachers = Teacher::with('user')->get();
        $this->loadCourses();
    }

    public function loadCourses()
    {
        $this->courses = Course::with('teacher.user')->get();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->course_id = null;
        $this->title = '';
        $this->description = '';
        $this->price = '';
        $this->teacher_id = '';
        $this->status = 'draft';
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'teacher_id' => 'required|exists:teachers,id',
            'status' => 'required|in:draft,published,archived',
        ]);

        $isNew = !$this->course_id;
        $oldCourse = $this->course_id ? Course::find($this->course_id) : null;

        $course = Course::updateOrCreate(['id' => $this->course_id], [
            'title' => $this->title,
            'slug' => \Illuminate\Support\Str::slug($this->title) . '-' . uniqid(),
            'description' => $this->description,
            'price' => $this->price,
            'teacher_id' => $this->teacher_id,
            'status' => $this->status,
        ]);

        // 1. Dispatch CoursePublished event
        if ($course->status === 'published' && (!$oldCourse || $oldCourse->status !== 'published')) {
            event(new \App\Events\CoursePublished($course));
        }

        // 2. Dispatch TeacherAssigned event
        if ($isNew || ($oldCourse && $oldCourse->teacher_id != $course->teacher_id)) {
            $teacher = \App\Models\Teacher::find($course->teacher_id);
            if ($teacher && $teacher->user) {
                event(new \App\Events\TeacherAssigned($course, $teacher->user));
            }
        }

        session()->flash('message', $this->course_id ? 'Course Updated Successfully.' : 'Course Created Successfully.');

        $this->closeModal();
        $this->loadCourses();
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $this->course_id = $id;
        $this->title = $course->title;
        $this->description = $course->description;
        $this->price = $course->price;
        $this->teacher_id = $course->teacher_id;
        $this->status = $course->status;
        $this->openModal();
    }

    public function delete($id)
    {
        Course::find($id)->delete();
        session()->flash('message', 'Course Deleted Successfully.');
        $this->loadCourses();
    }

    public function render()
    {
        return view('livewire.course-manager')->layout('layouts.livewire');
    }
}
