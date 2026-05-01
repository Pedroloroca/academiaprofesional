<?php

use App\Models\Course;
use App\Models\Teacher;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
});

// ── INDEX ────────────────────────────────────────────────────────────────────

test('unauthenticated user cannot list courses', function () {
    $this->getJson('/api/courses')->assertUnauthorized();
});

test('authenticated user can list courses', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $this->getJson('/api/courses')->assertOk();
});

// ── STORE ────────────────────────────────────────────────────────────────────

test('unauthenticated user cannot create a course', function () {
    $this->postJson('/api/courses', [])->assertUnauthorized();
});

test('admin can create a course with valid data', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $teacher = Teacher::factory()->create([
        'user_id' => User::factory()->create()->id,
    ]);

    $this->postJson('/api/courses', [
        'title'       => 'Curso de Laravel',
        'description' => 'Aprende Laravel desde cero',
        'price'       => 49.99,
        'teacher_id'  => $teacher->id,
    ])
        ->assertCreated()
        ->assertJsonFragment(['title' => 'Curso de Laravel']);

    $this->assertDatabaseHas('courses', ['title' => 'Curso de Laravel']);
});

test('creating a course fails with missing required fields', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $this->postJson('/api/courses', [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['title', 'description', 'price', 'teacher_id']);
});

// ── SHOW ─────────────────────────────────────────────────────────────────────

test('authenticated user can view a course', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    $course  = Course::factory()->create(['teacher_id' => $teacher->id]);

    $this->getJson("/api/courses/{$course->id}")
        ->assertOk()
        ->assertJsonFragment(['id' => $course->id]);
});

test('requesting a non-existent course returns 404', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $this->getJson('/api/courses/99999')->assertNotFound();
});

// ── UPDATE ───────────────────────────────────────────────────────────────────

test('admin can update a course', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    $course  = Course::factory()->create(['teacher_id' => $teacher->id]);

    $this->putJson("/api/courses/{$course->id}", ['title' => 'Título actualizado'])
        ->assertOk()
        ->assertJsonFragment(['title' => 'Título actualizado']);
});

// ── DESTROY ──────────────────────────────────────────────────────────────────

test('admin can delete a course', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
    $course  = Course::factory()->create(['teacher_id' => $teacher->id]);

    $this->deleteJson("/api/courses/{$course->id}")->assertNoContent();

    $this->assertDatabaseMissing('courses', ['id' => $course->id]);
});
