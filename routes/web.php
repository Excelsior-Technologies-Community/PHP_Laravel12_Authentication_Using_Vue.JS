<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginActivityController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Login Activity History
    Route::get('/login-history', [LoginActivityController::class, 'index'])
        ->name('login.history');

    // Example protected API route
    Route::get('/api/user-data', function () {
        return response()->json([
            'user' => auth()->user(),
            'timestamp' => now(),
        ]);
    })->name('api.user-data');
});

// Admin Routes
Route::middleware([
    'auth',
    'verified',
    'admin'
])
    ->group(function () {

        Route::get('/admin', function () {

            return Inertia::render('Admin/Dashboard');
        })->name('admin.dashboard');

        Route::get('/users', [UserController::class, 'index'])
            ->name('users.index');
    });

// Profile routes (already protected by Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
