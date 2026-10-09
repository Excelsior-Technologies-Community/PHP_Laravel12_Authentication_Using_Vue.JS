<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoginActivity;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $sort = $request->sort ?? 'id_asc';
        $perPage = $request->perPage ?? 10;
        $role = $request->input('role');
        $status = $request->input('status');

        $users = User::query()->withCount('loginActivities');

        // Search
        if ($search) {
            $users->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            });
        }

        // Role Filter
        if ($role && in_array($role, ['admin', 'manager', 'user'])) {
            $users->where('role', $role);
        }

        // Status Filter
        if ($status && in_array($status, ['active', 'blocked'])) {
            $users->where('status', $status);
        }

        // Sorting
        switch ($sort) {
            case 'id_asc':
                $users->orderBy('id', 'asc');
                break;
            case 'id_desc':
                $users->orderBy('id', 'desc');
                break;
            case 'name_asc':
                $users->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $users->orderBy('name', 'desc');
                break;
            case 'oldest':
                $users->orderBy('created_at', 'asc');
                break;
            case 'latest':
                $users->orderBy('created_at', 'desc');
                break;
            default:
                $users->orderBy('id', 'asc');
                break;
        }

        return Inertia::render('Users/Index', [
            'users' => $users->paginate($perPage)->withQueryString(),
            'filters' => [
                'search' => $search,
                'sort' => $sort,
                'perPage' => $perPage,
                'role' => $role,
                'status' => $status
            ],
            'statistics' => [
                'totalUsers' => User::count(),
                'verifiedUsers' => User::whereNotNull('email_verified_at')->count(),
                'activeUsers' => User::where('status', 'active')->count(),
                'blockedUsers' => User::where('status', 'blocked')->count(),
                'todayUsers' => User::whereDate('created_at', today())->count(),
                'thisMonthUsers' => User::whereMonth('created_at', now()->month)->count(),
                'adminUsers' => User::where('role', 'admin')->count(),
                'normalUsers' => User::where('role', 'user')->count(),
            ]
        ]);
    }

    /**
     * Admin Toggle User Status (Active <-> Blocked)
     */
    public function toggleStatus(Request $request, User $user)
    {
        // Prevent admin from blocking themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot block your own account.');
        }

        $newStatus = $user->status === 'blocked' ? 'active' : 'blocked';
        $user->update([
            'status' => $newStatus,
            'block_reason' => $newStatus === 'blocked' ? ($request->reason ?? 'Blocked by Administrator') : null,
        ]);

        return redirect()->back()->with('success', "User '{$user->name}' status updated to {$newStatus}.");
    }

    /**
     * Admin Update User Role
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,user,manager'
        ]);

        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return redirect()->back()->with('error', 'You cannot demote your own admin account.');
        }

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', "Role for '{$user->name}' updated to {$request->role}.");
    }

    /**
     * Admin Revoke User Sessions
     */
    public function revokeSessions(User $user)
    {
        LoginActivity::where('user_id', $user->id)
            ->whereNull('logout_time')
            ->update(['logout_time' => now()]);

        return redirect()->back()->with('success', "Revoked all active sessions for '{$user->name}'.");
    }
}
