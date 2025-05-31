<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Redirect;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $users = User::all();
        $project = Project::with(['projectUser.user'])->with('tasks.responsible')->with('tasks.reports.user')->with('user')->where('id', $id)->first();
        return Inertia::render('Project/Index', [
            'project' => $project,
            'users' => $users,
            'projectUsers' => $project->projectUser
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
    public function store(StoreProjectRequest $request)
    {
        try {
            $user = Auth::user();
            $user_id = $user->id;
    
            $project = Project::create([
                'user_id' => $user_id,
                'title' => $request->validated('title'),
                'description' => $request->validated('description'),
                'start_date' => $request->validated('start_date'),
                'end_date' => $request->validated('end_date'),
            ]);
            $project_user = ProjectUser::create([
                'project_id' => $project->id,
                'user_id' => $user_id,
                'role' => 'admin'
            ]);
    
            return redirect()->route('home')->with('success', 'Проект успешно создан.');
    
        }  catch (\Exception $e) {
            // Логируем ошибку (опционально)
            \Log::error('Ошибка при создании проекта: ' . $e->getMessage());
            
            return back()->withInput()->with('error', 'Произошла ошибка при создании проекта.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('home');
    }
}
