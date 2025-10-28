<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

// Routes publiques des cours
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');

// Routes d'authentification Breeze
require __DIR__.'/auth.php';

// Routes protégées
Route::middleware('auth')->group(function () {
    // Dashboard et profil
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Espace d'apprentissage
    Route::get('/learning/{course:slug}', [LearningController::class, 'show'])->name('learning.course');
    Route::get('/learning/{course:slug}/lesson/{lesson}', [LearningController::class, 'lesson'])->name('learning.lesson');
    Route::post('/learning/{course:slug}/complete-lesson/{lesson}', [LearningController::class, 'completeLesson'])->name('learning.complete-lesson');
    Route::post('/learning/{course:slug}/enroll', [LearningController::class, 'enroll'])->name('learning.enroll');
});