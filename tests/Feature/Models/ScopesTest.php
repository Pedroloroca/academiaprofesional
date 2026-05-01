<?php

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

beforeEach(function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
});

// ── Course Scopes ────────────────────────────────────────────────────────────

test('scopePublished filters courses correctly', function () {
    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    
    $publishedCourse = Course::factory()->create(['teacher_id' => $teacher->id, 'status' => 'published']);
    $draftCourse = Course::factory()->create(['teacher_id' => $teacher->id, 'status' => 'draft']);
    $archivedCourse = Course::factory()->create(['teacher_id' => $teacher->id, 'status' => 'archived']);

    $courses = Course::published()->get();

    expect($courses)->toHaveCount(1);
    expect($courses->first()->id)->toBe($publishedCourse->id);
});

test('scopeWithActiveEnrollments filters courses correctly', function () {
    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    
    $courseWithActive = Course::factory()->create(['teacher_id' => $teacher->id]);
    $courseWithoutActive = Course::factory()->create(['teacher_id' => $teacher->id]);
    
    $student1 = Student::factory()->create(['user_id' => User::factory()->create()->id]);
    $student2 = Student::factory()->create(['user_id' => User::factory()->create()->id]);

    // Active enrollment
    Enrollment::factory()->create([
        'course_id' => $courseWithActive->id,
        'student_id' => $student1->id,
        'status' => 'active'
    ]);

    // Completed enrollment
    Enrollment::factory()->create([
        'course_id' => $courseWithoutActive->id,
        'student_id' => $student2->id,
        'status' => 'completed'
    ]);

    $courses = Course::withActiveEnrollments()->get();

    expect($courses)->toHaveCount(1);
    expect($courses->first()->id)->toBe($courseWithActive->id);
});

// ── Student Scopes ───────────────────────────────────────────────────────────

test('scopeTopPerformers filters students correctly', function () {
    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);
    
    $topStudent = Student::factory()->create(['user_id' => User::factory()->create()->id]);
    $averageStudent = Student::factory()->create(['user_id' => User::factory()->create()->id]);

    Enrollment::factory()->create([
        'course_id' => $course->id,
        'student_id' => $topStudent->id,
        'final_grade' => 9.5
    ]);

    Enrollment::factory()->create([
        'course_id' => $course->id,
        'student_id' => $averageStudent->id,
        'final_grade' => 7.0
    ]);

    $students = Student::topPerformers()->get();

    expect($students)->toHaveCount(1);
    expect($students->first()->id)->toBe($topStudent->id);
});

test('scopeNeedsReinforcement filters students correctly', function () {
    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);
    
    $strugglingStudent = Student::factory()->create(['user_id' => User::factory()->create()->id]);
    $averageStudent = Student::factory()->create(['user_id' => User::factory()->create()->id]);
    $studentWithoutGrade = Student::factory()->create(['user_id' => User::factory()->create()->id]);

    Enrollment::factory()->create([
        'course_id' => $course->id,
        'student_id' => $strugglingStudent->id,
        'final_grade' => 4.5
    ]);

    Enrollment::factory()->create([
        'course_id' => $course->id,
        'student_id' => $averageStudent->id,
        'final_grade' => 6.0
    ]);

    Enrollment::factory()->create([
        'course_id' => $course->id,
        'student_id' => $studentWithoutGrade->id,
        'final_grade' => null
    ]);

    $students = Student::needsReinforcement()->get();

    expect($students)->toHaveCount(1);
    expect($students->first()->id)->toBe($strugglingStudent->id);
});
