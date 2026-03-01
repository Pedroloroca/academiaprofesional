<?php

use App\Models\User;
use App\Models\Student;
use Laravel\Sanctum\Sanctum;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('public users cannot list students', function () {
    $response = $this->getJson('/api/students');
    $response->assertUnauthorized();
});

test('admin can create students', function () {
    $this->seed();
    $admin = User::where('email', 'admin@admin.com')->first();
    
    Sanctum::actingAs($admin, ['*']);

    $userForStudent = User::factory()->create();

    $response = $this->postJson('/api/students', [
        'user_id' => $userForStudent->id,
        'date_of_birth' => '2000-01-01',
        'address' => 'Test Address 123'
    ]);

    $response->assertCreated();
    $this->assertDatabaseHas('students', ['user_id' => $userForStudent->id]);
});
