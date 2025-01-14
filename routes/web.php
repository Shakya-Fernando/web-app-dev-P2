<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Authentication Routes
Auth::routes();

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Course Routes
Route::middleware('auth')->group(function () {
    Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
    
    // Enrollment Route for Students
    Route::post('/courses/{course_id}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');

    // Teacher-specific routes
    Route::middleware('role:teacher')->group(function () {
        Route::post('/courses/{id}/enroll', [CourseController::class, 'enrollStudent'])->name('courses.enroll');
        
        // Display the upload form
        Route::get('/courses/upload', [CourseController::class, 'showUploadForm'])->name('courses.upload.form');

        // Handle the file upload
        Route::post('/courses/upload', [CourseController::class, 'uploadCourseFile'])->name('courses.upload');

        Route::get('/courses/{course_id}/assessments/create', [AssessmentController::class, 'create'])->name('assessments.create');
        Route::post('/courses/{course_id}/assessments', [AssessmentController::class, 'store'])->name('assessments.store');
        // Edit Assessment
        Route::get('/assessments/{id}/edit', [AssessmentController::class, 'edit'])->name('assessments.edit');
        Route::put('/assessments/{id}', [AssessmentController::class, 'update'])->name('assessments.update');
    });

    // Assessment Routes
    Route::get('/assessments/{id}', [AssessmentController::class, 'show'])->name('assessments.show');
    Route::get('/assessments/{assessment_id}/mark/{student_id}', [AssessmentController::class, 'markStudent'])->name('assessments.mark');
    Route::post('/assessments/{assessment_id}/mark/{student_id}', [AssessmentController::class, 'assignScore'])->name('assessments.score');

    // Review Routes
    Route::get('/reviews/{id}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::post('/assessments/{assessment_id}/reviews', [ReviewController::class, 'submitReview'])->name('reviews.submit');

    // Rating Routes
    Route::post('/reviews/{review_id}/rate', [ReviewController::class, 'rateReview'])->name('reviews.rate');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
