<?php

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

beforeEach(function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
});

test('can download welcome PDF', function () {
    $user = User::factory()->create();
    $this->actingAs($user)
        ->get(route('pdf.welcome', $user))
        ->assertOk()
        ->assertHeader('Content-Type', 'application/pdf');
});

test('can download invoice PDF', function () {
    $user = User::factory()->create();
    $student = Student::factory()->create(['user_id' => $user->id]);
    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);

    $enrollment = Enrollment::create([
        'student_id' => $student->id,
        'course_id' => $course->id,
        'enrolled_at' => now(),
        'status' => 'active'
    ]);

    $this->actingAs($user)
        ->get(route('pdf.invoice', $enrollment))
        ->assertOk()
        ->assertHeader('Content-Type', 'application/pdf');
});

test('can download certificate PDF', function () {
    $user = User::factory()->create();
    $student = Student::factory()->create(['user_id' => $user->id]);
    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);

    $enrollment = Enrollment::create([
        'student_id' => $student->id,
        'course_id' => $course->id,
        'enrolled_at' => now(),
        'status' => 'active'
    ]);

    $this->actingAs($user)
        ->get(route('pdf.certificate', $enrollment))
        ->assertOk()
        ->assertHeader('Content-Type', 'application/pdf');
});

test('can download course catalog PDF', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('pdf.course-catalog'))
        ->assertOk()
        ->assertHeader('Content-Type', 'application/pdf');
});

test('can download teacher report PDF', function () {
    $user = User::factory()->create();
    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);

    $this->actingAs($user)
        ->get(route('pdf.teacher-report', $teacher))
        ->assertOk()
        ->assertHeader('Content-Type', 'application/pdf');
});
