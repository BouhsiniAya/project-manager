<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Task;

class ApiController extends Controller
{
    public function getProjects()
    {
        return response()->json(Project::with('manager')->paginate(10));
    }

    public function getTasks()
    {
        return response()->json(Task::with('project', 'assignee')->paginate(10));
    }

    public function storeTask(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task = Task::create($validated);
        return response()->json($task, 201);
    }
}
