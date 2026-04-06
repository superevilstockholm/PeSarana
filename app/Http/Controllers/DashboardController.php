<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

// Models
use App\Models\User;
use App\Models\MasterData\Student;
use App\Models\MasterData\Aspiration;

// Enums
use App\Enums\RoleEnum;
use App\Enums\AspirationStatusEnum;

class DashboardController extends Controller
{
    public function admin_dashboard(Request $request): View
    {
        $stats = [
            'students_count' => Student::count(),
            'student_users_count' => User::where('role', RoleEnum::STUDENT)->count(),
            'admin_users_count' => User::where('role', RoleEnum::ADMIN)->count(),
            'aspirations_count' => Aspiration::count(),
            'pending_aspirations_count' => Aspiration::where('status', AspirationStatusEnum::PENDING)->count(),
            'on_going_aspirations_count' => Aspiration::where('status', AspirationStatusEnum::ON_GOING)->count(),
            'completed_aspirations_count' => Aspiration::where('status', AspirationStatusEnum::COMPLETED)->count(),
            'rejected_aspirations_count' => Aspiration::where('status', AspirationStatusEnum::REJECTED)->count(),
        ];
        return view('pages.dashboard.admin.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'stats' => $stats,
            'user' => $request->user(),
        ]);
    }

    public function student_dashboard(Request $request): View
    {
        $user = $request->user();
        $student = $user->student;
        $stats = [
            'student_aspirations_count' => Aspiration::where('student_id', $student->id)->count(),
            'student_pending_aspirations_count' => Aspiration::where('student_id', $student->id)->where('status', AspirationStatusEnum::PENDING)->count(),
            'student_on_going_aspirations_count' => Aspiration::where('student_id', $student->id)->where('status', AspirationStatusEnum::ON_GOING)->count(),
            'student_completed_aspirations_count' => Aspiration::where('student_id', $student->id)->where('status', AspirationStatusEnum::COMPLETED)->count(),
            'student_rejected_aspirations_count' => Aspiration::where('student_id', $student->id)->where('status', AspirationStatusEnum::REJECTED)->count(),
        ];
        return view('pages.dashboard.student.index', [
            'meta' => [
                'sidebarItems' => studentSidebarItems(),
            ],
            'stats' => $stats,
            'user' => $user,
        ]);
    }
}
