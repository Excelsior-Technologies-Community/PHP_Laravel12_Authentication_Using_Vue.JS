<?php

namespace App\Http\Controllers;

use App\Models\LoginActivity;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginActivityController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user->role === 'admin';

        if ($isAdmin) {
            $activities = LoginActivity::with('user')
                ->latest()
                ->paginate(15);
        } else {
            $activities = $user->loginActivities()
                ->latest()
                ->paginate(15);
        }

        $activeSessionsCount = LoginActivity::where('user_id', $user->id)
            ->whereNull('logout_time')
            ->count();

        return Inertia::render('Profile/LoginHistory', [
            'activities' => $activities,
            'isAdmin' => $isAdmin,
            'activeSessionsCount' => $activeSessionsCount
        ]);
    }

    /**
     * Logout other devices / sessions
     */
    public function logoutOtherDevices(Request $request)
    {
        $user = auth()->user();

        // Mark previous login activities as logged out
        LoginActivity::where('user_id', $user->id)
            ->whereNull('logout_time')
            ->update(['logout_time' => now()]);

        return redirect()->back()->with('success', 'Logged out from all other devices successfully.');
    }
}
