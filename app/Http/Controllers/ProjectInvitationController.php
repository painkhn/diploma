<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectInvitation;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectInvitationController extends Controller
{
    public function store(Request $request, Project $project)
    {
        // \Log::debug('Store invitation request:', $request->all()); // Логируем входные данные
        
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id',
        ]);

        // Проверяем, не является ли получатель владельцем проекта
        if ($project->user_id == $validated['recipient_id']) {
            return response()->json(['message' => 'Нельзя пригласить владельца проекта'], 422);
        }

        try {
            $invitation = ProjectInvitation::create([
                'project_id' => $project->id,
                'sender_id' => auth()->id(),
                'recipient_id' => $validated['recipient_id'],
                'status' => 'pending'
            ]);

            // \Log::debug('Invitation created:', $invitation->toArray()); // Логируем созданное приглашение
            
            // return response()->json([
            //     'message' => 'Приглашение успешно отправлено',
            //     'invitation' => $invitation
            // ]);

        } catch (\Exception $e) {
            // \Log::error('Error creating invitation:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Ошибка при создании приглашения'], 500);
        }
    }

    public function accept(ProjectInvitation $invitation)
    {
        if ($invitation->recipient_id !== Auth::id()) {
            abort(403);
        }

        $invitation->update(['status' => 'accepted']);

        $project_user = ProjectUser::create([
            'project_id' => $invitation->project->id,
            'user_id' => $invitation->recipient->id
        ]);
        
        // return response()->json(['message' => 'Приглашение принято']);
    }

    public function reject(ProjectInvitation $invitation)
    {
        if ($invitation->recipient_id !== Auth::id()) {
            abort(403);
        }

        $invitation->update(['status' => 'rejected']);
        
        // return response()->json(['message' => 'Приглашение отклонено']);
    }
}