<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\ProjectUser;
use App\Models\Report;
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
        // $users = User::all();
        $friends = Friend::with('receiver')->where('sender_id', Auth::id())->where('status', 'accepted')->get();
        
        $project = Project::with([
            'projectUser.user',
            'tasks.responsible',
            'tasks.reports.user',
            'user'
        ])->where('id', $id)->first();

        $currentProjectUser = ProjectUser::where('project_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        // Получаем ID всех задач проекта
        $taskIds = $project->tasks->pluck('id');

        // Загружаем все back-отчеты для задач проекта одним запросом
        $backReports = Report::with('user')
            ->whereIn('task_id', $taskIds)
            ->where('type', 'back')
            ->get();

        $reports = Report::with('user')
            ->whereIn('task_id', $taskIds)
            ->get();

        // dd($reports);

        return Inertia::render('Project/Index', [
            'project' => $project,
            // 'users' => $users,
            'friends' => $friends,
            'projectUsers' => $project->projectUser,
            'currentProjectUser' => $currentProjectUser,
            'backReports' => $backReports,
            'reports' => $reports
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
    
            return redirect()->back()->with('success', 'Проект успешно создан.');
    
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
