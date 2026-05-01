<?php

use App\Models\Student;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
});

// ── INDEX ────────────────────────────────────────────────────────────────────

test('unauthenticated user cannot list students', function () {
    $this->getJson('/api/students')->assertUnauthorized();
});

test('authenticated user can list students', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $this->getJson('/api/students')->assertOk();
});

// ── STORE ────────────────────────────────────────────────────────────────────

test('admin can create a student profile', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $newUser = User::factory()->create();

    $this->postJson('/api/students', [
        'user_id'       => $newUser->id,
        'date_of_birth' => '1995-05-20',
        'address'       => 'Calle Falsa 123',
    ])
        ->assertCreated()
        ->assertJsonFragment(['user_id' => $newUser->id, 'address' => 'Calle Falsa 123']);

    $this->assertDatabaseHas('students', ['user_id' => $newUser->id]);
});

test('creating a student with invalid date fails', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $newUser = User::factory()->create();

    $this->postJson('/api/students', [
        'user_id'       => $newUser->id,
        'date_of_birth' => 'no-es-fecha',
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['date_of_birth']);
});

test('cannot assign the same user to two student profiles', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $newUser = User::factory()->create();
    Student::factory()->create(['user_id' => $newUser->id]);

    $this->postJson('/api/students', ['user_id' => $newUser->id])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['user_id']);
});

// ── SHOW ─────────────────────────────────────────────────────────────────────

test('authenticated user can view a student', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $student = Student::factory()->create(['user_id' => User::factory()->create()->id]);

    $this->getJson("/api/students/{$student->id}")
        ->assertOk()
        ->assertJsonFragment(['id' => $student->id]);
});

// ── UPDATE ───────────────────────────────────────────────────────────────────

test('admin can update a student address', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $student = Student::factory()->create(['user_id' => User::factory()->create()->id]);

    $this->putJson("/api/students/{$student->id}", ['address' => 'Avenida Siempre Viva 742'])
        ->assertOk()
        ->assertJsonFragment(['address' => 'Avenida Siempre Viva 742']);
});

// ── DESTROY ──────────────────────────────────────────────────────────────────

test('admin can delete a student', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $student = Student::factory()->create(['user_id' => User::factory()->create()->id]);

    $this->deleteJson("/api/students/{$student->id}")->assertNoContent();

    $this->assertDatabaseMissing('students', ['id' => $student->id]);
});
