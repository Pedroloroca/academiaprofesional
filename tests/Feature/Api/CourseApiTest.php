<?php

use App\Models\User;
use App\Models\Course;
use Laravel\Sanctum\Sanctum;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('public users cannot create courses', function () {
    $response = $this->postJson('/api/courses', [
        'title' => 'New Course',
    ]);

    $response->assertUnauthorized();
});

test('admin can create courses', function () {
    $this->seed(); // Roles
    $admin = User::where('email', 'admin@admin.com')->first();
    
    Sanctum::actingAs($admin, ['*']);

    // Create a teacher for the course
    $teacher = User::factory()->create();
    $teacherProfile = \App\Models\Teacher::factory()->create(['user_id' => $teacher->id]);

    $response = $this->postJson('/api/courses', [
        'title' => 'New Course',
        'description' => 'Course Description',
        'price' => 99.99,
        'teacher_id' => $teacherProfile->id,
    ]);

    // Expect 201 Created
    $response->assertCreated();
    $this->assertDatabaseHas('courses', ['title' => 'New Course']);
});
