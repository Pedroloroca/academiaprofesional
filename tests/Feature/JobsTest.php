<?php

use App\Jobs\BulkEmailStudents;
use App\Jobs\CalculateStudentGPA;
use App\Jobs\GenerateCourseCertificate;
use App\Jobs\ProcessVideoUpload;
use App\Jobs\UpdateCourseStats;
use App\Models\User;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Support\Facades\Log;

beforeEach(function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
});

test('bulk email students job executes successfully', function () {
    Log::shouldReceive('info')
        ->twice();

    $teacher = Teacher::factory()->create();
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);

    $job = new BulkEmailStudents($course);
    $job->handle();

    expect(true)->toBeTrue();
});

test('calculate student gpa job executes successfully', function () {
    Log::shouldReceive('info')
        ->twice();

    $user = User::factory()->create();

    $job = new CalculateStudentGPA($user);
    $job->handle();

    expect(true)->toBeTrue();
});

test('generate course certificate job executes successfully', function () {
    Log::shouldReceive('info')
        ->twice();

    $user = User::factory()->create();
    $teacher = Teacher::factory()->create();
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);

    $job = new GenerateCourseCertificate($user, $course);
    $job->handle();

    expect(true)->toBeTrue();
});

test('process video upload job executes successfully', function () {
    Log::shouldReceive('info')
        ->twice();

    $job = new ProcessVideoUpload(12345);
    $job->handle();

    expect(true)->toBeTrue();
});

test('update course stats job executes successfully', function () {
    Log::shouldReceive('info')
        ->twice();

    $teacher = Teacher::factory()->create();
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);

    $job = new UpdateCourseStats($course);
    $job->handle();

    expect(true)->toBeTrue();
});
