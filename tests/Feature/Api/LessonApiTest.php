<?php

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Teacher;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
});

// ── INDEX ────────────────────────────────────────────────────────────────────

test('unauthenticated user cannot list lessons', function () {
    $this->getJson('/api/lessons')->assertUnauthorized();
});

test('authenticated user can list lessons', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $this->getJson('/api/lessons')->assertOk();
});

// ── STORE ────────────────────────────────────────────────────────────────────

test('admin can create a lesson', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);

    $this->postJson('/api/lessons', [
        'course_id'    => $course->id,
        'title'        => 'Introducción a Laravel',
        'content'      => 'Contenido de la lección...',
        'position'     => 1,
        'is_published' => true,
    ])
        ->assertCreated()
        ->assertJsonFragment(['title' => 'Introducción a Laravel']);

    $this->assertDatabaseHas('lessons', ['title' => 'Introducción a Laravel']);
});

test('creating a lesson with missing required fields fails', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $this->postJson('/api/lessons', [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['course_id', 'title', 'content']);
});

// ── SHOW ─────────────────────────────────────────────────────────────────────

test('authenticated user can view a lesson', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);
    $lesson = Lesson::factory()->create(['course_id' => $course->id]);

    $this->getJson("/api/lessons/{$lesson->id}")
        ->assertOk()
        ->assertJsonFragment(['id' => $lesson->id]);
});

// ── UPDATE ───────────────────────────────────────────────────────────────────

test('admin can update a lesson', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);
    $lesson = Lesson::factory()->create(['course_id' => $course->id]);

    $this->putJson("/api/lessons/{$lesson->id}", ['title' => 'Título Actualizado'])
        ->assertOk()
        ->assertJsonFragment(['title' => 'Título Actualizado']);
});

// ── DESTROY ──────────────────────────────────────────────────────────────────

test('admin can delete a lesson', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);
    $lesson = Lesson::factory()->create(['course_id' => $course->id]);

    $this->deleteJson("/api/lessons/{$lesson->id}")->assertNoContent();

    $this->assertDatabaseMissing('lessons', ['id' => $lesson->id]);
});
