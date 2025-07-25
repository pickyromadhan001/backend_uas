<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
 use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
 use App\Http\Controllers\CourseController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\CourseLecturerController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    //Akun
    // Route::controller(UserController::class)->group(function(){
    //     Route::get('/user', 'index');
    //     Route::post('/user/store', 'store');
    //     Route::patch('/user/{id}/update', 'update');
    //     Route::get('/user/{id}','show');
    //     Route::delete('/user/{id}', 'destroy');
    // });

    Route::apiResource('user', UserController::class);   
    
Route::apiResource('students', StudentController::class);
Route::apiResource('courses', CourseController::class);
Route::apiResource('lecturers', LecturerController::class);
Route::apiResource('enrollments', EnrollmentController::class);
Route::apiResource('course-lecturers', CourseLecturerController::class);

// 📊 Dashboard Count
Route::get('/dashboard-count', function () {
    return response()->json([
        'students' => \App\Models\Student::count(),
        'courses' => \App\Models\Course::count(),
        'lecturers' => \App\Models\Lecturer::count(),
        'enrollments' => \App\Models\Enrollment::count(),
        'course-lecturers' => \App\Models\CourseLecturer::count(),
       
    ]);
});

   
});





