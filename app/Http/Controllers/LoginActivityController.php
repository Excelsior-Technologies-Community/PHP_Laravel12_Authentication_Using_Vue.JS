<?php

namespace App\Http\Controllers;

use App\Models\LoginActivity;
use Inertia\Inertia;

class LoginActivityController extends Controller
{
    public function index()
    {
        $isAdmin = auth()->user()->role === 'admin';


        if ($isAdmin) {

            // Admin can see all users login history
            $activities = LoginActivity::with('user')
                ->latest()
                ->get();
        } else {

            // Normal user can see only own login history
            $activities = auth()
                ->user()
                ->loginActivities()
                ->latest()
                ->get();
        }


        return Inertia::render(
            'Profile/LoginHistory',
            [
                'activities' => $activities,
                'isAdmin' => auth()->user()->role === 'admin'
            ]
        );
    }
}
