<?php

use App\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('profile.edit'))
        ->assertOk();
});

test('profile name and email can be updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->patch(route('profile.update'), [
            'name'  => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

    $user->refresh();

    expect($user->name)->toBe('Updated Name');
    expect($user->email)->toBe('updated@example.com');
});

test('email verification is reset when email changes', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->patch(route('profile.update'), [
            'name'  => $user->name,
            'email' => 'new-email@example.com',
        ]);

    expect($user->refresh()->email_verified_at)->toBeNull();
});

test('email verification is kept when email does not change', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->patch(route('profile.update'), [
            'name'  => 'Same Name',
            'email' => $user->email,
        ]);

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

test('user can delete their account with correct password', function () {
    $user = User::factory()->create();
    $userId = $user->id;

    $this->actingAs($user)
        ->delete(route('profile.destroy'), ['password' => 'password']);

    $this->assertGuest();
    $this->assertDatabaseMissing('users', ['id' => $userId]);
});

test('account deletion fails with wrong password', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->delete(route('profile.destroy'), ['password' => 'wrong-password']);

    // User should still exist
    expect($user->fresh())->not->toBeNull();
});