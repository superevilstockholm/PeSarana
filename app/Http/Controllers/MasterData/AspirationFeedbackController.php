<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\Notification;
use App\Models\MasterData\Aspiration;
use App\Models\MasterData\AspirationFeedback;

// Enums
use App\Enums\AspirationStatusEnum;

class AspirationFeedbackController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validate([
            'aspiration_id' => ['required', 'exists:aspirations,id'],
            'content' => ['nullable', 'string'],
            'is_rejected' => ['nullable', 'boolean'],
        ]);
        $aspiration = Aspiration::findOrFail($validated['aspiration_id']);
        if (in_array($aspiration->status, [AspirationStatusEnum::COMPLETED, AspirationStatusEnum::REJECTED])) {
            return redirect()->route('dashboard.admin.master-data.aspirations.show', $aspiration->id)->withErrors('Tidak bisa membuat feedback jika status selesai atau ditolak.');
        }
        if ($aspiration->status === AspirationStatusEnum::PENDING) {
            $validated['status'] = $request->boolean('is_rejected')
                ? AspirationStatusEnum::REJECTED
                : AspirationStatusEnum::ON_GOING;
        } else if ($aspiration->status === AspirationStatusEnum::ON_GOING) {
            $validated['status'] = AspirationStatusEnum::COMPLETED;
        }
        unset($validated['is_rejected']);
        $validated['user_id'] = $user->id;
        AspirationFeedback::create($validated);
        $aspiration->update(['status' => $validated['status']]);
        $studentUser = $aspiration->student?->user;
        if ($studentUser) {
            Notification::create([
                'title' => 'Feedback untuk Aspirasi: ' . $aspiration->title,
                'content' => 'Admin telah memberikan tanggapan pada aspirasi "'. $aspiration->title . '". Silakan buka aspirasi untuk melihat tanggapan.',
                'user_id' => $studentUser->id,
            ]);
        }
        return redirect()->route('dashboard.admin.master-data.aspirations.show', $aspiration->id)->with('success', 'Berhasil membuat feedback.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AspirationFeedback $aspirationFeedback): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);
        $aspirationFeedback->update(['content' => $validated['content']]);
        return redirect()->route('dashboard.admin.master-data.aspirations.show', $aspirationFeedback->aspiration->id)->with('success', 'Berhasil memperbarui feedback.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AspirationFeedback $aspirationFeedback): RedirectResponse
    {
        $aspiration = $aspirationFeedback->aspiration;
        if ($aspiration->status === AspirationStatusEnum::COMPLETED && $aspirationFeedback->status === AspirationStatusEnum::ON_GOING) {
            return back()->withErrors('Tidak bisa menghapus feedback dengan status proses jika aspirasi statusnya selesai dan memiliki feedback selesai.');
        }
        if (in_array($aspiration->status, [AspirationStatusEnum::REJECTED, AspirationStatusEnum::ON_GOING])) {
            $aspiration->update(['status' => AspirationStatusEnum::PENDING]);
        } else if ($aspiration->status === AspirationStatusEnum::COMPLETED) {
            $aspiration->update(['status' => AspirationStatusEnum::ON_GOING]);
        }
        $aspirationFeedback->delete();
        return redirect()->route('dashboard.admin.master-data.aspirations.show', $aspiration->id)->with('success', 'Berhasil menghapus feedback.');
    }
}
