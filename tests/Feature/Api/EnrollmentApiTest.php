<?php

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
});

// ── INDEX ────────────────────────────────────────────────────────────────────

test('unauthenticated user cannot list enrollments', function () {
    $this->getJson('/api/enrollments')->assertUnauthorized();
});

test('authenticated user can list enrollments', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $this->getJson('/api/enrollments')->assertOk();
});

// ── STORE ────────────────────────────────────────────────────────────────────

test('admin can create an enrollment', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);
    $student = Student::factory()->create(['user_id' => User::factory()->create()->id]);

    $this->postJson('/api/enrollments', [
        'student_id' => $student->id,
        'course_id'  => $course->id,
        'status'     => 'active',
    ])
        ->assertCreated()
        ->assertJsonFragment(['student_id' => $student->id, 'course_id' => $course->id]);

    $this->assertDatabaseHas('enrollments', ['student_id' => $student->id, 'course_id' => $course->id]);
});

test('creating an enrollment fails with invalid data', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $this->postJson('/api/enrollments', [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['student_id', 'course_id']);
});

// ── SHOW ─────────────────────────────────────────────────────────────────────

test('authenticated user can view an enrollment', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);
    $student = Student::factory()->create(['user_id' => User::factory()->create()->id]);
    $enrollment = Enrollment::factory()->create(['student_id' => $student->id, 'course_id' => $course->id]);

    $this->getJson("/api/enrollments/{$enrollment->id}")
        ->assertOk()
        ->assertJsonFragment(['id' => $enrollment->id]);
});

// ── UPDATE ───────────────────────────────────────────────────────────────────

test('admin can update an enrollment', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);
    $student = Student::factory()->create(['user_id' => User::factory()->create()->id]);
    $enrollment = Enrollment::factory()->create(['student_id' => $student->id, 'course_id' => $course->id, 'status' => 'active']);

    $this->putJson("/api/enrollments/{$enrollment->id}", ['status' => 'completed', 'final_grade' => 9.5])
        ->assertOk()
        ->assertJsonFragment(['status' => 'completed', 'final_grade' => 9.5]);
});

// ── DESTROY ──────────────────────────────────────────────────────────────────

test('admin can delete an enrollment', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);
    $student = Student::factory()->create(['user_id' => User::factory()->create()->id]);
    $enrollment = Enrollment::factory()->create(['student_id' => $student->id, 'course_id' => $course->id]);

    $this->deleteJson("/api/enrollments/{$enrollment->id}")->assertNoContent();

    $this->assertDatabaseMissing('enrollments', ['id' => $enrollment->id]);
});
