<?php

namespace App\Http\Controllers;

use App\Enums\AspirationStatusEnum;
use Illuminate\View\View;
use Illuminate\Http\Request;

// Models
use App\Models\User;
use App\Models\MasterData\Student;
use App\Models\MasterData\Aspiration;

// Enums
use App\Enums\RoleEnum;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $stats = [
            'students_count' => Student::count(),
            'student_users_count' => User::where('role', RoleEnum::STUDENT)->count(),
            'aspirations_count' => Aspiration::count(),
            'completed_aspirations_count' => Aspiration::where('status', AspirationStatusEnum::COMPLETED)->count(),
        ];
        return view('pages.index', [
            'stats' => $stats
        ]);
    }
}
