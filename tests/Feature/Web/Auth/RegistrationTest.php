<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $this->get(route('register'))->assertOk();
});

test('new users can register', function () {
    $this->post(route('register.store'), [
        'name'                  => 'Test User',
        'email'                 => 'test@example.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
});