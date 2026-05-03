<?php

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Teacher;
use App\Models\User;

beforeEach(function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
});

// ── COURSE POLICY ─────────────────────────────────────────────────────────────

describe('CoursePolicy', function () {

    test('published courses are visible to guests', function () {
        $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
        $course  = Course::factory()->create(['teacher_id' => $teacher->id, 'status' => 'published']);

        expect((new \App\Policies\CoursePolicy())->view(null, $course))->toBeTrue();
    });

    test('draft courses are not visible to guests', function () {
        $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
        $course  = Course::factory()->create(['teacher_id' => $teacher->id, 'status' => 'draft']);

        expect((new \App\Policies\CoursePolicy())->view(null, $course))->toBeFalse();
    });

    test('admin can view draft courses', function () {
        $admin   = User::where('email', 'admin@admin.com')->first();
        $teacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
        $course  = Course::factory()->create(['teacher_id' => $teacher->id, 'status' => 'draft']);

        expect((new \App\Policies\CoursePolicy())->view($admin, $course))->toBeTrue();
    });

    test('admin can create courses', function () {
        $admin = User::where('email', 'admin@admin.com')->first();

        expect((new \App\Policies\CoursePolicy())->create($admin))->toBeTrue();
    });

    test('student cannot create courses', function () {
        $studentUser = User::factory()->create();
        $studentUser->assignRole('student');

        expect((new \App\Policies\CoursePolicy())->create($studentUser))->toBeFalse();
    });

    test('teacher can update their own course', function () {
        $teacherUser = User::factory()->create();
        $teacherUser->assignRole('teacher');
        $teacher = Teacher::factory()->create(['user_id' => $teacherUser->id]);
        $course  = Course::factory()->create(['teacher_id' => $teacher->id, 'status' => 'draft']);

        expect((new \App\Policies\CoursePolicy())->update($teacherUser, $course))->toBeTrue();
    });

    test('teacher cannot update another teacher course', function () {
        $teacherUser  = User::factory()->create();
        $teacherUser->assignRole('teacher');
        $teacher      = Teacher::factory()->create(['user_id' => $teacherUser->id]);

        $otherTeacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
        $course       = Course::factory()->create(['teacher_id' => $otherTeacher->id, 'status' => 'draft']);

        expect((new \App\Policies\CoursePolicy())->update($teacherUser, $course))->toBeFalse();
    });

    test('update policy does not crash if teacher has no profile', function () {
        $teacherUser = User::factory()->create();
        $teacherUser->assignRole('teacher');
        // No Teacher profile created intentionally
        $otherTeacher = Teacher::factory()->create(['user_id' => User::factory()->create()->id]);
        $course       = Course::factory()->create(['teacher_id' => $otherTeacher->id]);

        // Should return false, not throw an exception
        expect((new \App\Policies\CoursePolicy())->update($teacherUser, $course))->toBeFalse();
    });
});

// ── ENROLLMENT POLICY ─────────────────────────────────────────────────────────

describe('EnrollmentPolicy', function () {

    test('admin can view any enrollments', function () {
        $admin = User::where('email', 'admin@admin.com')->first();

        expect((new \App\Policies\EnrollmentPolicy())->viewAny($admin))->toBeTrue();
    });

    test('student cannot view all enrollments list', function () {
        $studentUser = User::factory()->create();
        $studentUser->assignRole('student');

        expect((new \App\Policies\EnrollmentPolicy())->viewAny($studentUser))->toBeFalse();
    });

    test('admin can create, update and delete enrollments', function () {
        $admin = User::where('email', 'admin@admin.com')->first();
        $enrollment = Enrollment::factory()->create();

        expect((new \App\Policies\EnrollmentPolicy())->create($admin))->toBeTrue();
        expect((new \App\Policies\EnrollmentPolicy())->update($admin, $enrollment))->toBeTrue();
        expect((new \App\Policies\EnrollmentPolicy())->delete($admin, $enrollment))->toBeTrue();
    });

    test('student cannot create, update, delete, restore enrollments', function () {
        $studentUser = User::factory()->create();
        $studentUser->assignRole('student');
        $enrollment = Enrollment::factory()->create();

        expect((new \App\Policies\EnrollmentPolicy())->create($studentUser))->toBeFalse();
        expect((new \App\Policies\EnrollmentPolicy())->update($studentUser, $enrollment))->toBeFalse();
        expect((new \App\Policies\EnrollmentPolicy())->delete($studentUser, $enrollment))->toBeFalse();
        expect((new \App\Policies\EnrollmentPolicy())->restore($studentUser, $enrollment))->toBeFalse();
        expect((new \App\Policies\EnrollmentPolicy())->forceDelete($studentUser, $enrollment))->toBeFalse();
    });

    test('admin can restore and force delete enrollments', function () {
        $admin = User::where('email', 'admin@admin.com')->first();
        $enrollment = Enrollment::factory()->create();

        expect((new \App\Policies\EnrollmentPolicy())->restore($admin, $enrollment))->toBeTrue();
        expect((new \App\Policies\EnrollmentPolicy())->forceDelete($admin, $enrollment))->toBeTrue();
    });
});
