<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('courses', \App\Http\Controllers\Api\CourseController::class);
    Route::apiResource('teachers', \App\Http\Controllers\Api\TeacherController::class);
    Route::apiResource('students', \App\Http\Controllers\Api\StudentController::class);
    Route::apiResource('lessons', \App\Http\Controllers\Api\LessonController::class);
    Route::apiResource('enrollments', \App\Http\Controllers\Api\EnrollmentController::class);
});
