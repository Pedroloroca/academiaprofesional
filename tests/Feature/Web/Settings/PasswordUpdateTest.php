<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('password update page is displayed', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('user-password.edit'))
        ->assertOk();
});

test('password can be updated with correct current password', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->from(route('user-password.edit'))
        ->put(route('user-password.update'), [
            'current_password'      => 'password',
            'password'              => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
});

test('wrong current password prevents password update', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->from(route('user-password.edit'))
        ->put(route('user-password.update'), [
            'current_password'      => 'wrong-password',
            'password'              => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    // Password should remain unchanged
    expect(Hash::check('password', $user->refresh()->password))->toBeTrue();
});