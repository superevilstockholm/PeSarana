<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

// Models
use App\Models\Notification;

// Enums
use App\Enums\RoleEnum;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $limit = (int) $request->query('limit', 10);
        if ($limit > 100) {
            $limit = 100;
        }
        $query = Notification::query();
        if ($user->role === RoleEnum::STUDENT) {
            $query->where('user_id', $user->id);
        }
        $notifications = $query->paginate($limit)->append($request->excepts('page'));
        return view($user->role === RoleEnum::ADMIN
            ? adminSidebarItems()
            : studentSidebarItems(), [
            'meta' => [
                'sidebarItems' => $user->role === RoleEnum::ADMIN
                    ? adminSidebarItems()
                    : studentSidebarItems(),
            ],
            'notifications' => $notifications,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Notification $notification)
    {
        $user = $request->user();
        if ($user->role === RoleEnum::STUDENT && $notification->user_id !== $user->id) {
            abort(403, 'Forbidden');
        }
        $notification->delete();
        return redirect()->route($user->role === RoleEnum::ADMIN
            ? 'dashboard.admin.notifications.index'
            : 'dashboard.student.notifications.index')->with('success', 'Berhasil menghapus notifikasi.');
    }
}
