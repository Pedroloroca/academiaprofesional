<?php

use App\Models\Teacher;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
});

// ── INDEX ────────────────────────────────────────────────────────────────────

test('unauthenticated user cannot list teachers', function () {
    $this->getJson('/api/teachers')->assertUnauthorized();
});

test('authenticated user can list teachers', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $this->getJson('/api/teachers')->assertOk();
});

// ── STORE ────────────────────────────────────────────────────────────────────

test('admin can create a teacher profile', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $newUser = User::factory()->create();

    $this->postJson('/api/teachers', [
        'user_id'     => $newUser->id,
        'bio'         => 'Profesor experto en Laravel',
        'website_url' => 'https://ejemplo.com',
    ])
        ->assertCreated()
        ->assertJsonFragment(['user_id' => $newUser->id]);

    $this->assertDatabaseHas('teachers', ['user_id' => $newUser->id]);
});

test('creating a teacher with an invalid url fails', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $newUser = User::factory()->create();

    $this->postJson('/api/teachers', [
        'user_id'     => $newUser->id,
        'website_url' => 'no-es-una-url',
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['website_url']);
});

test('cannot assign the same user to two teacher profiles', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $newUser = User::factory()->create();
    Teacher::factory()->create(['user_id' => $newUser->id]);

    $this->postJson('/api/teachers', ['user_id' => $newUser->id])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['user_id']);
});

// ── SHOW ─────────────────────────────────────────────────────────────────────

test('authenticated user can view a teacher', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);

    $this->getJson("/api/teachers/{$teacher->id}")
        ->assertOk()
        ->assertJsonFragment(['id' => $teacher->id]);
});

// ── UPDATE ───────────────────────────────────────────────────────────────────

test('admin can update a teacher bio', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);

    $this->putJson("/api/teachers/{$teacher->id}", ['bio' => 'Nueva bio actualizada'])
        ->assertOk()
        ->assertJsonFragment(['bio' => 'Nueva bio actualizada']);
});

// ── DESTROY ──────────────────────────────────────────────────────────────────

test('admin can delete a teacher', function () {
    $admin = User::where('email', 'admin@admin.com')->first();
    Sanctum::actingAs($admin);

    $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);

    $this->deleteJson("/api/teachers/{$teacher->id}")->assertNoContent();

    $this->assertDatabaseMissing('teachers', ['id' => $teacher->id]);
});
