<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

// Enums
use App\Enums\RoleEnum;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        return view('pages.dashboard.profile.index', [
            'meta' => [
                'sidebarItems' => $user->role === RoleEnum::ADMIN
                    ? adminSidebarItems()
                    : studentSidebarItems(),
            ],
            'user' => $user,
        ]);
    }
}
