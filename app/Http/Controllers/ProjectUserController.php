<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectInvitation;
use App\Models\ProjectUser;
use App\Http\Requests\StoreProjectUserRequest;
use App\Http\Requests\UpdateProjectUserRequest;
use Illuminate\Http\Request;

class ProjectUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreProjectUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectUser $projectUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectUser $projectUser)
    {
        //
    }

    public function updateRole($projectId, $userId, Request $request)
    {
        $projectUser = ProjectUser::where('project_id', $projectId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $isAdmin = ProjectUser::where('project_id', $projectId)
            ->where('user_id', auth()->id())
            ->where('role', 'admin')
            ->exists();

        if (!$isAdmin) {
            return response()->json(['error' => 'Недостаточно прав'], 403);
        }

        $projectUser->update([
            'role' => $request->role
        ]);

        // return response()->json(['success' => true]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectUserRequest $request, ProjectUser $projectUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($projectId, $userId)
    {
        $isAdmin = ProjectUser::where('project_id', $projectId)
                ->where('user_id', auth()->id())
                ->where('role', 'admin')
                ->exists();
        if (!$isAdmin) {
            return response()->json(['error' => 'Недостаточно прав'], 403);
        }

        $projectOwnerId = Project::findOrFail($projectId)->user_id;
        if ($userId == $projectOwnerId) {
            return response()->json(['error' => 'Нельзя удалить владельца проекта'], 403);
        }

        ProjectUser::where('project_id', $projectId)
        ->where('user_id', $userId)
        ->delete();
        ProjectInvitation::where('recipient_id', $userId)->delete();
        
        // return response()->json(['success' => true]);
    }
}
