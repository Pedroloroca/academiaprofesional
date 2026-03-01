<?php

use App\Models\User;
use App\Models\Teacher;
use Laravel\Sanctum\Sanctum;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('public users cannot create teachers', function () {
    $response = $this->postJson('/api/teachers', [
        'bio' => 'New Teacher Bio',
    ]);

    $response->assertUnauthorized();
});

test('admin can create teachers', function () {
    $this->seed();
    $admin = User::where('email', 'admin@admin.com')->first();
    
    Sanctum::actingAs($admin, ['*']);

    $userForTeacher = User::factory()->create();

    $response = $this->postJson('/api/teachers', [
        'user_id' => $userForTeacher->id,
        'bio' => 'A great teacher bio',
        'website_url' => 'https://example.com'
    ]);

    $response->assertCreated();
    $this->assertDatabaseHas('teachers', ['user_id' => $userForTeacher->id]);
});
