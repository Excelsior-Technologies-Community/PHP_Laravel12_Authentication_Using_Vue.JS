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

Route::middleware(['auth', 'verified', 'active'])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Login Activity History & Device Revocation
    Route::get('/login-history', [LoginActivityController::class, 'index'])
        ->name('login.history');
    Route::post('/login-history/logout-other-devices', [LoginActivityController::class, 'logoutOtherDevices'])
        ->name('login.logout-other-devices');

    // Protected API route
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
    'active',
    'admin'
])->group(function () {

    Route::get('/admin', function () {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'totalUsers' => \App\Models\User::count(),
                'activeUsers' => \App\Models\User::where('status', 'active')->count(),
                'blockedUsers' => \App\Models\User::where('status', 'blocked')->count(),
                'totalLogins' => \App\Models\LoginActivity::count(),
                'recentLogins' => \App\Models\LoginActivity::with('user')->latest()->limit(5)->get(),
            ]
        ]);
    })->name('admin.dashboard');

    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');
    
    // User Management Actions
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
        ->name('users.toggle-status');
    Route::post('/users/{user}/update-role', [UserController::class, 'updateRole'])
        ->name('users.update-role');
    Route::post('/users/{user}/revoke-sessions', [UserController::class, 'revokeSessions'])
        ->name('users.revoke-sessions');
});

// Profile routes
Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
