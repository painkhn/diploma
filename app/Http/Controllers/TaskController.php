<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        // $task = Task::where('project_id', $id)->get();
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
    public function store(StoreTaskRequest $request, $id)
    {
        // $project_id = Project::where('id', $id);
        // $project_users = ProjectUser::with('user')->where('project_id', $project_id)->get();
        // dd($request);
        $task = Task::create([
            'user_id' => Auth::id(),
            'project_id' => $id,
            'responsible_id' => $request->responsible_id,
            'title' => $request->title,
            'description' => $request->description,
            'end_date' => $request->end_date,
            'status' => 'pending'
            // 'project_users' => $project_users
        ]);

        // return response()->json(['message' => 'Task created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'responsible_id' => $request->responsible_id,
        ]);
        
        // return response()->json([
        //     'message' => 'Task updated successfully',
        //     'task' => $task
        // ]);
    }

    public function cancel(UpdateTaskRequest $request, Task $task)
    {
        $task->update([
            'status' => 'canceled'
        ]);
    }

    public function returnBack(UpdateTaskRequest $request, Task $task)
    {
        $task->update([
            'status' => 'pending'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
