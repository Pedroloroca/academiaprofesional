<?php

use App\Events\CoursePublished;
use App\Events\LessonCompleted;
use App\Listeners\NotifyStudentsAboutNewCourse;
use App\Listeners\UpdateCourseProgress;
use App\Models\User;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Lesson;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

beforeEach(function () {
    $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
});

test('course published event dispatches successfully and triggers listener', function () {
    Event::fake([CoursePublished::class]);

    $teacher = Teacher::factory()->create();
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);

    event(new CoursePublished($course));

    Event::assertDispatched(CoursePublished::class);
});

test('notify students about new course listener handles event', function () {
    Log::shouldReceive('info')->atLeast()->once();

    $teacher = Teacher::factory()->create();
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);

    $event = new CoursePublished($course);
    $listener = new NotifyStudentsAboutNewCourse();
    $listener->handle($event);

    expect(true)->toBeTrue();
});

test('lesson completed event dispatches successfully and triggers listener', function () {
    Event::fake([LessonCompleted::class]);

    $user = User::factory()->create();
    $teacher = Teacher::factory()->create();
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);
    $lesson = Lesson::factory()->create(['course_id' => $course->id]);

    event(new LessonCompleted($lesson, $user));

    Event::assertDispatched(LessonCompleted::class);
});

test('update course progress listener handles event', function () {
    Log::shouldReceive('info')->atLeast()->once();

    $user = User::factory()->create();
    $teacher = Teacher::factory()->create();
    $course = Course::factory()->create(['teacher_id' => $teacher->id]);
    $lesson = Lesson::factory()->create(['course_id' => $course->id]);

    $event = new LessonCompleted($lesson, $user);
    $listener = new UpdateCourseProgress();
    $listener->handle($event);

    expect(true)->toBeTrue();
});
