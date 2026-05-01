<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

test('password reset request screen can be rendered', function () {
    $this->get(route('password.request'))->assertOk();
});

test('password reset link can be requested', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.email'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class);
});

test('password reset screen can be rendered with valid token', function () {
    Notification::fake();

    $user = User::factory()->create();
    $this->post(route('password.email'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
        $this->get(route('password.reset', $notification->token))->assertOk();
        return true;
    });
});

test('password can be reset with a valid token', function () {
    Notification::fake();

    $user = User::factory()->create();
    $this->post(route('password.email'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $this->post(route('password.update'), [
            'token'                 => $notification->token,
            'email'                 => $user->email,
            'password'              => 'new-password',
            'password_confirmation' => 'new-password',
        ])->assertSessionHasNoErrors();

        return true;
    });
});

test('password cannot be reset with an invalid token', function () {
    $user = User::factory()->create();

    $this->post(route('password.update'), [
        'token'                 => 'invalid-token',
        'email'                 => $user->email,
        'password'              => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ])->assertSessionHasErrors('email');
});