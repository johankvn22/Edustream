<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Teacher;
use App\Http\Controllers\Student;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [AuthController::class, 'showLanding'])->name('landing');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Teacher Routes (role: teacher)
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [Teacher\DashboardController::class, 'index'])->name('dashboard');
    
    // Courses
    Route::resource('courses', Teacher\CourseController::class);
    Route::post('courses/{id}/assign', [Teacher\CourseController::class, 'assignClasses'])->name('courses.assign');
    
    // Lessons
    Route::post('courses/{courseId}/lessons', [Teacher\LessonController::class, 'store'])->name('lessons.store');
    Route::delete('lessons/{id}', [Teacher\LessonController::class, 'destroy'])->name('lessons.destroy');
    
    // Students
    Route::resource('students', Teacher\StudentController::class)->only(['index', 'create', 'store', 'destroy']);
    
    // Promotion
    Route::get('/promotion', [Teacher\PromotionController::class, 'index'])->name('promotion.index');
    Route::post('/promotion/process', [Teacher\PromotionController::class, 'process'])->name('promotion.process');
});

// Student Routes (role: student)
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [Student\DashboardController::class, 'index'])->name('dashboard');
    
    // Lessons
    Route::get('/courses/{courseId}/lessons/{lessonId}', [Student\LessonController::class, 'show'])->name('lessons.show');
    Route::post('/lessons/{lessonId}/quiz/submit', [Student\LessonController::class, 'submitQuiz'])->name('quiz.submit');
});
