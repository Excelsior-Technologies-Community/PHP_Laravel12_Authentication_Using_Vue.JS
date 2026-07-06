<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $sort = $request->sort ?? 'id_asc';
        $perPage = $request->perPage ?? 4;

        $users = User::query();

        // Search
        if ($search) {
            $users->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
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

            'users' => $users
                ->paginate($perPage)
                ->withQueryString(),

            'filters' => [

                'search' => $search,

                'sort' => $sort,

                'perPage' => $perPage

            ],

            'statistics' => [

                'totalUsers' => User::count(),

                'verifiedUsers' => User::whereNotNull('email_verified_at')->count(),

                'todayUsers' => User::whereDate('created_at', today())->count(),

                'thisMonthUsers' => User::whereMonth('created_at', now()->month)->count(),

            ]

        ]);
    }
}