<?php

use App\Http\Controllers\BugController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('login');
});

// ── Authenticated Routes ──
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ── Admin Only Routes ──
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except('show');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    });

    // ── Admin Only: Create/Edit Projects ──
    Route::middleware('role:admin')->group(function () {
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    });

    // ── All Authenticated Users: View Projects ──
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    // ── Bug Routes ──
    Route::get('/bugs', [BugController::class, 'index'])->name('bugs.index');

    // Create bugs: Admin and Tester (must be before {bug} wildcard)
    Route::middleware('role:admin,tester')->group(function () {
        Route::get('/bugs/create', [BugController::class, 'create'])->name('bugs.create');
        Route::post('/bugs', [BugController::class, 'store'])->name('bugs.store');
    });

    Route::get('/bugs/{bug}', [BugController::class, 'show'])->name('bugs.show');

    // Edit/Delete bugs: Admin and Developer (for status update)
    Route::middleware('role:admin,developer')->group(function () {
        Route::get('/bugs/{bug}/edit', [BugController::class, 'edit'])->name('bugs.edit');
        Route::put('/bugs/{bug}', [BugController::class, 'update'])->name('bugs.update');
    });

    Route::middleware('role:admin')->group(function () {
        Route::delete('/bugs/{bug}', [BugController::class, 'destroy'])->name('bugs.destroy');
    });

    // Comments: All authenticated users
    Route::post('/bugs/{bug}/comments', [CommentController::class, 'store'])->name('comments.store');
});

require __DIR__ . '/auth.php';
