<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $limit = (int) $request->query('limit', 10);
        if ($limit > 100) {
            $limit = 100;
        }
        $users = User::paginate($limit)->appends($request->except('page'));
        return view('pages.dashboard.admin.master-data.user.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('pages.dashboard.admin.master-data.user.show', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'user' => $user->load(['student'])->loadCount(['aspiration_feedbacks']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
