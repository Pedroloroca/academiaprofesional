<?php

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

beforeEach(function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
});

test('academy:recalculate-stats runs without error', function () {
    $this->artisan('academy:recalculate-stats')
        ->assertExitCode(0);
});

test('academy:sync-external-data runs without error', function () {
    $this->artisan('academy:sync-external-data')
        ->assertExitCode(0);
});

test('academy:cleanup-old-enrollments runs without error', function () {
    $this->artisan('academy:cleanup-old-enrollments')
        ->assertExitCode(0);
});

test('academy:generate-monthly-report runs without error', function () {
    $this->artisan('academy:generate-monthly-report')
        ->assertExitCode(0);
});

test('academy:notify-teachers runs without error', function () {
    $this->artisan('academy:notify-teachers')
        ->assertExitCode(0);
});

test('academy:archive-old-courses runs without error', function () {
    $this->artisan('academy:archive-old-courses')
        ->assertExitCode(0);
});

test('academy:unpublish-empty-courses runs without error', function () {
    $this->artisan('academy:unpublish-empty-courses')
        ->assertExitCode(0);
});
