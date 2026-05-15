<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\File;
use App\Notifications\TaskAssigned;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with('project', 'assignee');

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $tasks = $query->paginate(10)->withQueryString();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $projects = Project::all();
        $users = User::all();
        return view('tasks.create', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:todo,in_progress,done',
            'due_date' => 'nullable|date',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'project_id' => $validated['project_id'],
            'user_id' => $validated['user_id'],
            'status' => $validated['status'],
            'due_date' => $validated['due_date'] ?? null,
        ]);

        if ($task->user_id) {
            $user = User::find($task->user_id);
            if ($user) {
                $user->notify(new TaskAssigned($task));
            }
        }

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/tasks');
            File::create([
                'name' => $request->file('file')->getClientOriginalName(),
                'path' => $path,
                'task_id' => $task->id,
                'user_id' => auth()->id() ?? 1,
            ]);
        }

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $task->load('comments.user', 'files');
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        $users = User::all();
        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:todo,in_progress,done',
            'due_date' => 'nullable|date',
        ]);

        $oldUserId = $task->user_id;
        $task->update($validated);

        if ($task->user_id && $task->user_id !== $oldUserId) {
            $user = User::find($task->user_id);
            if ($user) {
                $user->notify(new TaskAssigned($task));
            }
        }

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('tasks.index')->with('error', 'Unauthorized action. Only admins can delete tasks.');
        }
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);
        $task->update(['status' => $validated['status']]);
        return back()->with('success', 'Status updated.');
    }
}
