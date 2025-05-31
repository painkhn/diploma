<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Http\Requests\StoreProjectUserRequest;
use App\Http\Requests\UpdateProjectUserRequest;

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

    public function makeAdminProjectUser(StoreProjectUserRequest $request, $id)
    {
        $project = Project::where('id', $id)->first();
        $project_user = ProjectUser::create([
            
        ]);
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
    public function destroy($id)
    {
        $user = ProjectUser::where('user_id', $id);
        $user->delete();
        // $projectUser->delete();
    }
}
